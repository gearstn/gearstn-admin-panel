<?php

namespace Modules\Conversation\Http\Controllers;

use App\Classes\CollectionPaginate;
use App\Classes\SortModel;
use App\Http\Requests\SearchRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Conversation\Entities\Conversation;
use Modules\Conversation\Http\Requests\StoreConversationRequest;
use Modules\Conversation\Http\Requests\CheckForConversationRequest;
use Modules\Conversation\Http\Requests\UpdateConversationRequest;
use Modules\Conversation\Http\Resources\ConversationResource;
use Modules\Mail\Http\Controllers\MailController;
use Modules\Mail\Http\Requests\OpenConversationMailRequest;
use Modules\SparePart\Entities\SparePart;
use Spatie\Searchable\Search;

class ConversationController extends Controller
{

    public function index()
    {
        $conversations = Conversation::paginate(number_in_page());
        return ConversationResource::collection($conversations)->additional(['status' => 200, 'message' => 'Conversations fetched successfully']);
    }
    /**
     * Store a newly created resource in storage.
     * @param StoreConversationRequest $request
     * @return Application|ResponseFactory|JsonResponse|Response
     */
    public function store(StoreConversationRequest $request)
    {
        $inputs = $request->validated();
        $inputs['model_id'] = $inputs['product_id'];
        $inputs['product_type'] == 'machine' ?  $inputs['model_type'] = class_basename(Machine::class) : $inputs['model_type'] = class_basename(SparePart::class);
        unset($inputs['product_id'],$inputs['product_type']);
        $conversation = Conversation::create($inputs);

//        Send Mail To the machine owner
        $mail_parameters = [
            'model_id' => $inputs['model_id'],
            'model_type' => $inputs['model_type'],
            'acquire_id' => $inputs['acquire_id'],
            'owner_id' => $inputs['owner_id'],
        ];
        // $response = redirect()->route('open-conversation-with-seller' , $mail_parameters );
        // if($response->status() != 200) { return $response; }

        return response()->json(new ConversationResource($conversation), 200);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $conversation = Conversation::findOrFail($id);
        return response()->json(new ConversationResource($conversation), 200);
    }


        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConversationRequest $request, $id)
    {
        $inputs = $request->validated();
        $conversation = Conversation::find($id);
        $conversation->update($inputs);
        return response()->json(new ConversationResource($conversation), 200);
    }

    public function get_user_conversations(): JsonResponse
    {
        $auth_id = Auth::user()->id;
        $conversations = Conversation::where('acquire_id', $auth_id)->orWhere('owner_id', $auth_id)->get();
        $result = [];
        foreach ($conversations as $conversation){
            if ($conversation->acquire_id == $auth_id)
                $result[json_encode(User::find($conversation->owner_id,['id','first_name', 'last_name']))][] = new ConversationResource($conversation);
            else
                $result[json_encode(User::find($conversation->acquire_id,['id','first_name', 'last_name']))][] = new ConversationResource($conversation);
        }
        return response()->json($result, 200);
    }

    public function check_for_conversation(CheckForConversationRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        $id = Auth::user()->id;
        $conversation = Conversation::where('acquire_id', $id)->Where('model_id', $inputs['product_id'])->first();
        return response()->json(new ConversationResource($conversation), 200);
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $conversation = Conversation::findOrFail($id);
        $conversation->delete();
        return response()->json(new ConversationResource($conversation), 200);
    }

    public function search(SearchRequest $request){
        $inputs = $request->validated();
        if (isset($inputs['search_query']) && $inputs['search_query'] != null) {
            $q = (new Search())
                    ->registerModel(Category::class, ['model_type'])
                    ->search($inputs['search_query']);
            $q = ConversationResource::collection( array_column($q->toArray(), 'searchable') );
        } else {
            $q = Conversation::all();
        }
        //Sort the collection of categories if requested
        $q = SortModel::sort($q, $inputs['sort_by']);
        $paginatedResult = CollectionPaginate::paginate($q, 10);
        return ConversationResource::collection($paginatedResult)->additional(['status' => 200, 'message' => 'Conversations fetched successfully']);
    }

}
