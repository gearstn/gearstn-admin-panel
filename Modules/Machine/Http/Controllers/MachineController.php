<?php

namespace Modules\Machine\Http\Controllers;

use App\Classes\CollectionPaginate;
use App\Classes\POST_Caller;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\MachineModel\Entities\MachineModel;
use Modules\MachineModel\Http\Controllers\MachineModelController;
use Modules\MachineModel\Http\Requests\StoreMachineModelRequest;
use Modules\Machine\Entities\Machine;
use Modules\Machine\Http\Requests\StoreMachineRequest;
use Modules\Machine\Http\Requests\UpdateMachineRequest;
use Modules\Machine\Http\Resources\MachineResource;
use Modules\Machine\Jobs\SetMachineHideDataJob;
use Modules\Mail\Http\Controllers\MailController;
use Modules\Mail\Http\Requests\StoreMachineMailRequest;
use Modules\Subscription\Entities\ExtraPlan;
use Modules\Upload\Http\Controllers\UploadController;
use Modules\Upload\Http\Requests\StoreFileRequest;
use Modules\Upload\Http\Requests\StoreUploadRequest;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $machines = Machine::paginate(number_in_page());
        return MachineResource::collection($machines)->additional(['status' => 200, 'message' => 'Machines fetched successfully']);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(StoreMachineRequest $request)
    {
        $inputs = $request->validated();
        $user = User::find($inputs['seller_id']);
        $user_subscriptions = $user->subscriptions()->get();
        $user_extra_subscriptions = ExtraPlan::where('user_id', $user->id)->get();
        $using_extra_plan_id = null;
        $plan_ends_at = null;
        // if ($user_subscriptions->count() > 0) {
        //     foreach ($user_subscriptions as $plan) {
        //         if (str_contains($plan->slug, 'mozaa')) {
        //             $subscription = app('rinvex.subscriptions.plan')->find($plan->plan_id);
        //             $subscription->features();
        //             $feature_slug_machines = null;
        //             $feature_slug_photos = null;
        //             $feature_slug_videos = null;
        //             $photos_count = isset($inputs['photos']) ? count($inputs['photos']) : 0;
        //             $videos_count = isset($inputs['videos']) ? count($inputs['videos']) : 0;
        //             foreach ($subscription->features as $feature) {
        //                 if (str_contains($feature->slug, 'number-of-listing')) {
        //                     $feature_slug_machines = $feature->slug;
        //                 }

        //                 if (str_contains($feature->slug, 'total-photos')) {
        //                     $feature_slug_photos = $feature->slug;
        //                 }

        //                 if (str_contains($feature->slug, 'total-videos')) {
        //                     $feature_slug_videos = $feature->slug;
        //                 }

        //             }
        //             $video_feature = null;
        //             $plan->getFeatureValue($feature_slug_videos) == 'false' ? $video_feature == 0 : $video_feature = 1;

        //             if ($plan->getFeatureRemainings($feature_slug_machines) > 0 && $plan->getFeatureRemainings($feature_slug_photos) > $photos_count ) {
        //                 $plan_ends_at = $plan->ends_at;
        //                 $plan->recordFeatureUsage($feature_slug_machines, 1);
        //                 $plan->recordFeatureUsage($feature_slug_photos, $photos_count);
        //                 if($video_feature){
        //                     if($plan->getFeatureRemainings($feature_slug_videos) > $videos_count){
        //                         $plan->recordFeatureUsage($feature_slug_videos, $videos_count);
        //                     }
        //                 }

        //             } elseif ($user_extra_subscriptions->count() > 0) {
        //                 foreach ($user_extra_subscriptions as $subscription) {
        //                     $number_of_listing = $subscription->number_of_listing;
        //                     $listed_machine = $subscription->machines == null ? [] : json_decode($subscription->machines);

        //                     if ($number_of_listing > count($listed_machine)) {
        //                         $using_extra_plan_id = $subscription->id;
        //                         break;
        //                     }
        //                 }
        //                 if ($using_extra_plan_id == null) {
        //                     return response()->json([
        //                         'message_en' => 'You Have acrossed limit of your subscription, you have to upgrade your account',
        //                         'message_ar' => 'لقد وصلت للحد الاقصى لتسجيل الماكينات , يجب ترقية حسابك',
        //                     ], 422);
        //                 }

        //             } else {
        //                 return response()->json([
        //                     'message_en' => 'You Have acrossed limit of your subscription, you have to upgrade your account',
        //                     'message_ar' => 'لقد وصلت للحد الاقصى لتسجيل الماكينات , يجب ترقية حسابك',
        //                 ], 422);
        //             }
        //         }
        //         else {
        //             return response()->json([
        //                 'message_en' => "You don't have any subscription",
        //                 'message_ar' => 'ليس لديك أي اشتراك',
        //             ], 422);
        //         }
        //     }
        // } elseif ($user_extra_subscriptions->count() > 0) {
        //     foreach ($user_extra_subscriptions as $subscription) {
        //         $number_of_listing = $subscription->number_of_listing;
        //         $listed_machine = json_decode($subscription->number_of_listing);
        //         if ($number_of_listing > count($listed_machine)) {
        //             $using_extra_plan_id = $subscription->id;
        //             break;
        //         }
        //     }
        //     if ($using_extra_plan_id == null) {
        //         return response()->json([
        //             'message_en' => 'You Have acrossed limit of your subscription, you have to upgrade your account',
        //             'message_ar' => 'لقد وصلت للحد الاقصى لتسجيل الماكينات , يجب ترقية حسابك',
        //         ], 422);
        //     }
        // }
        // else{
        //     return response()->json([
        //         'message_en' => "You don't have any subscription",
        //         'message_ar' => 'ليس لديك أي اشتراك',
        //     ], 422);
        // }

        //Uploads route to upload images and get array of ids

        $data = [
            'photos' => $inputs['photos'],
            'seller_id' => $user->id,
        ];
        $post = new Post_Caller(UploadController::class, 'store', StoreUploadRequest::class, $data);
        $response = $post->call();
        if ($response->status() != 200) {return $response;}
        $inputs['images'] = $response->getContent();
        unset($inputs['photos']);

        if (isset($inputs['videos'])) {
            $data = [
                'videos' => $inputs['videos'],
                'seller_id' => $user->id,
            ];
            $post = new Post_Caller(UploadController::class, 'upload_video', Request::class , $data);
            $response = $post->call();
            if ($response->status() != 200) {return $response;}
            $inputs['videos'] = $response->getContent();
        }

        //If the client wants to create a non existing model
        if ($inputs['model_id'] == 0 && isset($inputs['new_model'])) {
            $data = [
                'title_en' => $inputs['new_model'],
                'title_ar' => $inputs['new_model'],
                'category_id' => $inputs['category_id'],
                'sub_category_id' => $inputs['sub_category_id'],
                'manufacture_id' => $inputs['manufacture_id'],
            ];
            $post = new Post_Caller(MachineModelController::class, 'store', StoreMachineModelRequest::class, $data);
            $response = $post->call();
            if ($response->status() != 200) {return $response;}
            $inputs['model_id'] = json_decode($response->getContent())->id;
        }

        if (isset($inputs['report_file'])) {
            $data = [
                'file' => [$inputs['report_file']],
                'seller_id' => $user->id,
            ];
            $post = new Post_Caller(UploadController::class, 'upload_report_file', StoreFileRequest::class, $data);
            $response = $post->call();
            if ($response->status() != 200) {return $response;}
            $inputs['report_id'] = $response->getContent();
            unset($inputs['report_file']);
        }

        if (isset($inputs['serial_photo'])) {
            $data = [
                'photos' => [$inputs['serial_photo']],
                'seller_id' => $user->id,
            ];
            $post = new Post_Caller(UploadController::class, 'store', StoreUploadRequest::class, $data);
            $response = $post->call();
            if ($response->status() != 200) {return $response;}
            $inputs['serial_photo_id'] = $response->getContent();
            unset($inputs['serial_photo']);
        }

        if (isset($inputs['hour_meter_photo'])) {
            $data = [
                'photos' => [$inputs['hour_meter_photo']],
                'seller_id' => $user->id,
            ];
            $post = new Post_Caller(UploadController::class, 'store', StoreUploadRequest::class, $data);
            $response = $post->call();
            if ($response->status() != 200) {return $response;}
            $inputs['hour_meter_photo_id'] = $response->getContent();
            unset($inputs['hour_meter_photo']);
        }

        if (!isset($inputs['rent_hours'])) {
            $inputs['rent_hours'] = 0;
        }

        $machine = Machine::create($inputs);
        $machine->sku = random_int(10000000, 99999999);
        $model_title = MachineModel::findorFail($machine->model_id)->title_en;
        $machine->slug = $machine->year . '-' . $machine->manufacture->title_en . '-' . $model_title . '-' . $machine->sku;
        $machine->save();

        //Saving Machine in the extra subscription if used
        //And Dispatch hide machine job
        $details = ['machine_id' => $machine->id];
        if ($using_extra_plan_id !== null) {
            $extra_plan = ExtraPlan::find($using_extra_plan_id);
            $extra_plan_machines = json_decode($extra_plan->machines);
            $extra_plan_machines[] = $machine->id;
            $extra_plan->machines = json_encode($extra_plan_machines);
            $extra_plan->save();
            SetMachineHideDataJob::dispatch($details)->delay(Carbon::parse($extra_plan->ends_at));
        }
        elseif ($plan_ends_at !== null) {
            SetMachineHideDataJob::dispatch($details)->delay(Carbon::parse($plan_ends_at));
        }

        //Send Mail To the machine owner
        $data = [
            'machine_id' => $machine->id,
            'seller_id' => $inputs['seller_id'],
        ];
        // $post = new Post_Caller(MailController::class, 'store_machine', StoreMachineMailRequest::class, $data);
        // $response = $post->call();
        //$response = redirect()->route('store-machine' , $mail_parameters );
        if ($response->status() != 200) {return $response;}

        return response()->json(new MachineResource($machine), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     */
    public function show($id)
    {
        $machine = Machine::find($id);
        return response()->json(new MachineResource($machine), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateMachineRequest $request, int $id): JsonResponse
    {
        $inputs = $request->validated();
        $machine = Machine::find($id);
        $machine->update($inputs);
        return response()->json(new MachineResource($machine), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $machine = Machine::find($id);
        $machine->delete();
        return response('deleted successfully',200);
    }

    public function search_filter(Request $request): AnonymousResourceCollection
    {
        $inputs = $request->all();
        //Full Search in all fields
        if (isset($inputs['search_query']) && $inputs['search_query'] != null) {
            $q = Machine::search($inputs['search_query'])->get();
        } else {
            $q = Machine::all();
        }

        //Converting result to Resources Collection
        MachineResource::collection($q);

        //Filter for every attribute we want to filter
        $q = items_filter($q, 1, 'approved'); // To get approved
        $q = items_filter($q, isset($inputs['category_id']) ? $inputs['category_id'] : null, 'category_id');
        $q = items_filter($q, isset($inputs['sub_category_id']) ? $inputs['sub_category_id'] : null, 'sub_category_id');
        $q = items_filter($q, isset($inputs['manufacture_id']) ? $inputs['manufacture_id'] : null, 'manufacture_id');
        $q = items_filter($q, isset($inputs['model_id']) ? $inputs['model_id'] : null, 'model_id');
        $q = items_filter($q, isset($inputs['sell_type']) ? $inputs['sell_type'] : null, 'sell_type');
        $q = items_filter($q, isset($inputs['condition']) ? $inputs['condition'] : null, 'condition');
        $q = items_filter($q, isset($inputs['country_id']) ? $inputs['country_id'] : null, 'country_id');
        $q = items_filter($q, isset($inputs['city_id']) ? $inputs['city_id'] : null, 'city_id');
        $q = items_range_filter($q, isset($inputs['min_price']) ? $inputs['min_price'] : null, isset($inputs['max_price']) ? $inputs['max_price'] : null, 'price');
        $q = items_range_filter($q, isset($inputs['min_year']) ? $inputs['min_year'] : null, isset($inputs['max_year']) ? $inputs['max_year'] : null, 'year');
        $q = items_range_filter($q, isset($inputs['min_hours']) ? $inputs['min_hours'] : null, isset($inputs['max_hours']) ? $inputs['max_hours'] : null, 'hours');

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
        return MachineResource::collection($paginatedResult)->additional(['status' => 200, 'message' => 'Machines fetched successfully']);
    }

    public function getMinMaxOfField(): JsonResponse
    {
        $results = [];
        $results['max_price'] = Machine::max('price');
        $results['min_price'] = Machine::min('price');
        $results['max_year'] = Machine::max('year');
        $results['min_year'] = Machine::min('year');
        $results['max_hours'] = Machine::max('hours');
        $results['min_hours'] = Machine::min('hours');
        return response()->json($results, 200);
    }

    public function getRelatedMachines(Request $request): AnonymousResourceCollection
    {
        $inputs = $request->all();
        $related_machines = Machine::where('approved', '=', 1)->where('id', '!=', $inputs['id'])->where('sub_category_id', $inputs['sub_category_id'])->take(10)->get();
        return MachineResource::collection($related_machines)->additional(['status' => 200, 'message' => 'Machines fetched successfully']);
    }

    public function get_machine_price(Request $request): JsonResponse
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            "machine_id" => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $machine_price = Machine::find($inputs['machine_id'])->price;
        return response()->json(['price' => $machine_price], 200);
    }

    public function latest_machines(Request $request): AnonymousResourceCollection
    {
        $inputs = $request->all();
        $machines = Machine::orderBy('created_at', 'desc')->where('approved', 1)->take((int) $inputs['number'])->get();
        return MachineResource::collection($machines)->additional(['status' => 200, 'message' => 'Machines fetched successfully']);
    }

    public function user_machines(): AnonymousResourceCollection
    {
        $machines = Machine::where('seller_id', Auth::user()->id)->get();
        return MachineResource::collection($machines)->additional(['status' => 200, 'message' => 'Machines fetched successfully']);
    }

    public function add_machine_view(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            "machine_id" => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $machine = Machine::find($inputs['machine_id']);
        views($machine)->record();
    }

    public function delete_machine_image(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            "machine_id" => 'required',
            "image_id" => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $machine = Machine::find($inputs['machine_id']);
        $images = json_decode($machine->images);

        foreach (array_keys($images, $inputs['image_id']) as $key) {
            unset($images[$key]);
        }
        $machine->images = json_encode($images);
        $machine->save();

        $data = [
            'id' => $inputs['image_id'],
        ];
        $post = new Post_Caller(UploadController::class, 'destroy', Request::class , $data);
        $response = $post->call();
        if ($response->status() != 200) {return $response;}

        return response()->json(new MachineResource($machine), 200);
    }
}
