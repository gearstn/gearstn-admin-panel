<?php

namespace Modules\Subscription\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Subscription\Entities\ExtraPlan;
use Modules\Subscription\Http\Resources\ExtraPlanResource;
use Modules\Subscription\Http\Resources\SubscriptionResource;
use Modules\Subscription\Http\Resources\UsersSubscriptionsResource;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $subscriptions = app('rinvex.subscriptions.plan')->all();
        return SubscriptionResource::collection($subscriptions);
    }

     /**
     *
     * @return \Illuminate\Http\Response
     */
    public function get_plans_filtered(){
        $subscriptions =  app('rinvex.subscriptions.plan')->select('id','slug','name')->get();
        return response()->json(['data' => $subscriptions], 200);
    }

    public function all_users_subscriptions()
    {
        $subscriptions = app('rinvex.subscriptions.plan_subscription')->all();
        return UsersSubscriptionsResource::collection($subscriptions);
    }

    public function get_subscription($id)
    {
        $subscription = app('rinvex.subscriptions.plan_subscription')->find($id);
        return response()->json(new UsersSubscriptionsResource($subscription), 200);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        return response('Working on Storing', 200);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $subscription = app('rinvex.subscriptions.plan')->find($id);
        return response()->json(new SubscriptionResource($subscription), 200);
    }

    public function update(Request $request)
    {
        $inputs = $request->all();
        return response('Working on Updating', 200);
    }

    public function update_subscription(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'slug' => 'required',
            'name' => 'required',
            'description' => 'required',
            'subscriber_id' => 'required',
            'plan_id' => 'required',
            'usages' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $subscription_usages = app('rinvex.subscriptions.plan_subscription_usage')->where('subscription_id', $inputs['plan_id'])->get();
        foreach ($subscription_usages as $subscription_usage) {
            $feature = app('rinvex.subscriptions.plan_feature')->find($subscription_usage->feature_id);
            foreach($inputs['usages'] as $usage){
                if($usage['feature_id']['id'] == $subscription_usage->id){
                    $subscription_usage->used = $usage['used'];
                    $subscription_usage->save();
                }
            }
        }
        $subscription = app('rinvex.subscriptions.plan_subscription')->find($inputs['plan_id']);
        return response()->json(new UsersSubscriptionsResource($subscription), 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscription = app('rinvex.subscriptions.plan')->where($id)->get();
        $subscription->delete();
        return response()->json(new SubscriptionResource($subscription), 200);
    }

    public function subscribe(Request $request)
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, ["plan_id" => "required", 'subscriber_id' => 'required']);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $subscription = app('rinvex.subscriptions.plan')->find($inputs['plan_id']);
        $user = User::find($inputs['subscriber_id']);
        $user_subscriptions = $user->activeSubscriptions()->toArray();

        $user_machine_distributor = false;
        $user_spare_parts_distributor = false;

        // If target plan is true then the target plan is for a machine distributor
        // else If target plan is false then the target plan is for a spare parts distributor
        $target_plan = str_contains($subscription->slug, 'machine-distributor');

        if ($user_subscriptions !== []) {
            foreach ($user_subscriptions as $user_subscription) {
                if( str_contains($user_subscription['slug'], 'machine-distributor')) $user_machine_distributor = true;
                if( str_contains($user_subscription['slug'], 'spare-parts-distributor')) $user_spare_parts_distributor = true;
            }
            if($user_machine_distributor && $user_spare_parts_distributor){
                return response()->json([
                    'message_en' => 'You Have an active subscription for machines and spare parts you can not subscribe again',
                    'message_ar' => 'لديك اشتراك نشط للماكينات وقطع الغيار لا يمكنك الاشتراك مرة أخرى',
                ],422);
            }
            else if($user_machine_distributor && $target_plan){
                return response()->json([
                    'message_en' => 'You Have an active subscription for machines you can not subscribe again',
                    'message_ar' => 'لديك اشتراك نشط في للماكينات لا يمكنك الاشتراك فيها مرة أخرى',
                ],422);
            }
            else if($user_spare_parts_distributor && !$target_plan){
                return response()->json([
                    'message_en' => 'You Have an active subscription for spare parts you can not subscribe again',
                    'message_ar' => 'لديك اشتراك نشط لقطع الغيار لا يمكنك الاشتراك مرة أخرى',
                ],422);
            }
        }

        $user = $user->newSubscription($subscription->slug.'-'.$user->id,$subscription);
        return response()->json([
            'message_en' => 'You Have subscribed successfully',
            'message_ar' => 'لقد قمت بالاشتراك بنجاح',
        ],200);

    }

    public function unsubscribe(Request $request)
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, ["subscription_slug" => "required"]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $user = User::find(auth()->user()->id);
        $subscription = $user->activeSubscriptions()->where('slug', $inputs['subscription_slug'])->first();
        $subscription = app('rinvex.subscriptions.plan_subscription')->find($subscription->id)->cancel(true)->delete();
        return response()->json([
            'message_en' => 'You Have unsubscribed successfully',
            'message_ar' => 'لقد قمت بالاشتراك بنجاح',
        ], 200);
    }

    public function user_subscriptions_by_type(Request $request)
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, ["subscription_type" => "required"]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $user = User::find(auth()->user()->id);
        $plans = $user->activeSubscriptions()->all() ? $user->activeSubscriptions()->all() : false;
        foreach ($plans as $plan) {
            $active_plans_ids[] = app('rinvex.subscriptions.plan')->where('id', $plan->plan_id)->first()->id;
        }
        $active_plans = app('rinvex.subscriptions.plan')->whereIn('id', $active_plans_ids)->where('slug', 'LIKE', '%'.$inputs['subscription_type'].'%')->get();
        return SubscriptionResource::collection( $active_plans )->additional(['status' => 200, 'message' => 'Subscriptions fetched successfully']);
    }

    public function user_all_subscriptions()
    {
        $user = User::find(auth()->user()->id);
        $plans = $user->activeSubscriptions()->all() ? $user->activeSubscriptions()->all() : false;
        foreach ($plans as $plan) {
            $active_plans_ids[] = app('rinvex.subscriptions.plan')->where('id', $plan->plan_id)->first()->id;
        }
        $active_plans = app('rinvex.subscriptions.plan')->whereIn('id', $active_plans_ids)->get();
        return SubscriptionResource::collection( $active_plans )->additional(['status' => 200, 'message' => 'Subscriptions fetched successfully']);
    }

    public function user_extra_subscriptions()
    {
        $user_id = auth()->user()->id;
        $extra_plans = ExtraPlan::where('user_id',$user_id)->get();
        return ExtraPlanResource::collection($extra_plans)->additional(['status' => 200, 'message' => 'Extra Subscriptions fetched successfully']);
    }

    public function extra_plan_subscribe(Request $request)
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            'number_of_listing' => 'required',
            'number_of_months' => 'required',
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $inputs['starts_at'] =  Carbon::now();
        $inputs['ends_at'] =  Carbon::now()->addMonths($inputs['number_of_months']);
        $inputs['photos_of_listing'] =  5;
        $user_extra_plans_count = ExtraPlan::where('user_id', $inputs['user_id'])->count();
        $user_extra_plans_count = $user_extra_plans_count + 1;
        $inputs['name'] =  'extra-plan-' . $inputs['user_id'] . '-' . $user_extra_plans_count;
        ExtraPlan::create($inputs);
        return response()->json([
            'message_en' => 'You Have subscribed for your extra plan successfully',
            'message_ar' => 'لقد اشتركت في خطتك الإضافية بنجاح',
        ], 200);
    }
}
