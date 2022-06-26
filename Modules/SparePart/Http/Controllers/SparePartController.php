<?php

namespace Modules\SparePart\Http\Controllers;

use App\Classes\CollectionPaginate;
use App\Classes\POST_Caller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Mail\Http\Controllers\MailController;
use Modules\SparePart\Entities\SparePart;
use Modules\SparePart\Http\Requests\StoreSparePartRequest;
use Modules\SparePart\Http\Resources\SparePartResource;
use Modules\SparePart\Jobs\SetSparePartHideDateJob;
use Modules\SparePartModel\Entities\SparePartModel;
use Modules\SparePartModel\Http\Controllers\SparePartModelController;
use Modules\Upload\Http\Controllers\UploadController;
use Modules\Upload\Http\Requests\StoreUploadRequest;
use Modules\SubCategory\Entities\SubCategory;
use Modules\Manufacture\Entities\Manufacture;
use Modules\SparePart\Http\Requests\SparePartUpdateRequest;

class SparePartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $spare_parts = SparePart::paginate(number_in_page());
        return SparePartResource::collection($spare_parts)->additional(['status' => 200, 'message' => 'Spare Parts fetched successfully']);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreSparePartRequest $request)
    {
        $inputs = $request->validated();
        $user = User::find($inputs['seller_id']);
        $user_subscriptions = $user->subscriptions()->get();
        $plan_ends_at = null;
        if ($user_subscriptions->count() > 0) {
            foreach ($user_subscriptions as $plan) {
                if (str_contains($plan->slug, 'spare-parts')) {
                    $subscription = app('rinvex.subscriptions.plan')->find($plan->plan_id);
                    $subscription->features();
                    $feature_slug_spare_parts = null;
                    $feature_slug_photos = null;
                    $photos_count = isset($inputs['photos']) ? count($inputs['photos']) : 0;
                    foreach ($subscription->features as $feature) {
                        if (str_contains($feature->slug, 'number-of-spare-parts')) {
                            $feature_slug_spare_parts = $feature->slug;
                        }

                        if (str_contains($feature->slug, 'photos-per-spare-parts')) {
                            $feature_slug_photos = $feature->slug;
                        }
                    }
                    if ($plan->getFeatureValue($feature_slug_photos) >= $photos_count) {
                        $plan_ends_at = $plan->ends_at;
                        $plan->recordFeatureUsage($feature_slug_spare_parts, 1);
                        // $plan->recordFeatureUsage($feature_slug_photos, $photos_count);
                    } else {
                        return response()->json([
                            'message_en' => 'You Have acrossed limit of your subscription, you have to upgrade your account',
                            'message_ar' => 'لقد وصلت للحد الاقصى لتسجيل الماكينات , يجب ترقية حسابك',
                        ], 422);
                    }
                }
            }
        } else {
            return response()->json([
                'message_en' => "You don't have any subscription",
                'message_ar' => 'ليس لديك أي اشتراك',
            ], 422);
        }

        //Uploads route to upload images and get array of ids
        $data = [
            'photos' => $inputs['photos'],
            'seller_id' => $user->id,
        ];
        $post = new POST_Caller(UploadController::class, 'store', StoreUploadRequest::class, $data);
        $response = $post->call();
        if ($response->status() != 200) {
            return $response;
        }
        $inputs['images'] = $response->getContent();
        unset($inputs['photos']);


        $manufacture = Manufacture::find($inputs['manufacture_id']);
        if ($manufacture == null)
            unset($inputs['manufacture_id']);

        $spare_part = SparePart::create($inputs);
        $spare_part->sku = random_int(10000000, 99999999);
        $sub_category_title = SubCategory::findorFail($spare_part->sub_category_id)->title_en;
        $sub_category_title = preg_replace("/[\s_]/", "-", $sub_category_title);
        $spare_part->slug = $sub_category_title . '-' . $spare_part->sku;
        $spare_part->save();

        //Dispatch hide spare-part job
        $details = ['spare_part_id' => $spare_part->id];
        if ($plan_ends_at !== null) {
            SetSparePartHideDateJob::dispatch($details)->delay(Carbon::parse($plan_ends_at));
        }

        // Send Mail To the machine owner
        $data = [
            'spare_part_id' => $spare_part->id,
            'seller_id' => $inputs['seller_id'],
        ];
        $post = new Post_Caller(MailController::class, 'store_spare_part', Request::class, $data);
        $response = $post->call();
        if ($response->status() != 200) {
            return $response;
        }

        return response()->json(new SparePartResource($spare_part), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $spare_part = SparePart::find($id);
        return response()->json(new SparePartResource($spare_part), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SparePartUpdateRequest $request, $id)
    {
        $inputs = $request->validated();
        $spare_part = SparePart::find($id);
        if (isset($inputs['photos'])) {
            $data = [
                'photos' => [$inputs['photos']],
                'seller_id' => $spare_part->seller_id,
            ];
            $post = new Post_Caller(UploadController::class, 'store', Request::class, $data);
            $response = $post->call();
            if ($response->status() != 200) {
                return $response;
            }
            $inputs['images'] = $response->getContent();
            unset($inputs['photos']);
        }

        $spare_part->update($inputs);
        return response()->json(new SparePartResource($spare_part), 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $spare_part = SparePart::findOrFail($id);
        $spare_part->delete();
        return response()->json(new SparePartResource($spare_part), 200);
    }

    public function search_filter(Request $request): AnonymousResourceCollection
    {
        $inputs = $request->all();
        //Full Search in all fields
        if (isset($inputs['search_query']) && $inputs['search_query'] != null) {
            $q = SparePart::search($inputs['search_query'])->get();
        } else {
            $q = SparePart::all();
        }

        //Converting result to Resources Collection
        SparePartResource::collection($q);

        //Filter for every attribute we want to filter
        $q = items_filter($q, 1, 'approved'); // To get approved
        $q = items_filter($q, isset($inputs['category_id']) ? $inputs['category_id'] : null, 'category_id');
        $q = items_filter($q, isset($inputs['sub_category_id']) ? $inputs['sub_category_id'] : null, 'sub_category_id');
        // $q = items_filter($q, isset($inputs['manufacture_id']) ? $inputs['manufacture_id'] : null, 'manufacture_id');
        $q = items_filter($q, isset($inputs['country_id']) ? $inputs['country_id'] : null, 'country_id');
        $q = items_filter($q, isset($inputs['city_id']) ? $inputs['city_id'] : null, 'city_id');
        $q = items_range_filter($q, isset($inputs['min_price']) ? $inputs['min_price'] : null, isset($inputs['max_price']) ? $inputs['max_price'] : null, 'price');
        // $q = items_range_filter($q, isset($inputs['min_year']) ? $inputs['min_year'] : null, isset($inputs['max_year']) ? $inputs['max_year'] : null, 'year');

        //Sort the collection of machines if requested
        $q = $q->when(isset($inputs['sort_by']) && $inputs['sort_by'] != null, function ($q) use ($inputs) {
            $sort = explode('_', $inputs['sort_by']);
            if ($sort[1] == 'asc') {
                return $q->sortBy($sort[0]);
            } else {
                return $q->SortByDesc($sort[0]);
            }
        });

        //Adding Pagination to a collection
        $paginatedResult = CollectionPaginate::paginate($q, 10);
        return SparePartResource::collection($paginatedResult)->additional(['status' => 200, 'message' => 'Spare parts fetched successfully']);
    }


    public function getMinMaxOfField(): JsonResponse
    {
        $results = [];
        $results['max_price'] = SparePart::max('price') || 0;
        $results['min_price'] = SparePart::min('price') || 0;
        $results['max_year'] =  0;
        $results['min_year'] =  0;
        $results['max_hours'] = 0;
        $results['min_hours'] = 0;
        return response()->json($results, 200);
    }

    public function getRelatedSpareParts(Request $request): AnonymousResourceCollection
    {
        $inputs = $request->all();
        $related_spare_parts = SparePart::where('approved', '=', 1)->where('id', '!=', $inputs['id'])->where('sub_category_id', $inputs['sub_category_id'])->take(10)->get();
        return SparePartResource::collection($related_spare_parts)->additional(['status' => 200, 'message' => 'Spare Parts fetched successfully']);
    }

    public function get_spare_part_price(Request $request): JsonResponse
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            "spare_part_id" => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $spare_part_price = SparePart::find($inputs['spare_part_id'])->price;
        return response()->json(['price' => $spare_part_price], 200);
    }

    public function latest_spare_parts(Request $request): AnonymousResourceCollection
    {
        $inputs = $request->all();
        $spare_parts = SparePart::orderBy('created_at', 'desc')->where('approved', 1)->take((int) $inputs['number'])->get();
        return SparePartResource::collection($spare_parts)->additional(['status' => 200, 'message' => 'Spare Parts fetched successfully']);
    }

    public function user_spare_parts(): AnonymousResourceCollection
    {
        $spare_parts = SparePart::where('seller_id', Auth::user()->id)->get();
        return SparePartResource::collection($spare_parts)->additional(['status' => 200, 'message' => 'Spare Parts fetched successfully']);
    }

    public function add_spare_part_view(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            "spare_part_id" => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $spare_part = SparePart::find($inputs['spare_part_id']);
        views($spare_part)->record();
    }
}
