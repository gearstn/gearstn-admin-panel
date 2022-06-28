<?php

namespace Modules\Subscription\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersSubscriptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $usages = [];
        $subscription_usages = app('rinvex.subscriptions.plan_subscription_usage')->where('subscription_id', $this->id)->get();
        foreach ($subscription_usages as $subscription_usage) {
            $feature = app('rinvex.subscriptions.plan_feature')->find($subscription_usage->feature_id);

            $usages[] = [
                'id' => $subscription_usage->id,
                'subscription_id' => $subscription_usage->subscription_id,
                'feature_id' => SubscriptionFeatureResource::make($feature),
                'used' => $subscription_usage->used,
                'valid_until' => $subscription_usage->valid_until,
                'timezone' => $subscription_usage->timezone,
                'created_at' => $subscription_usage->created_at,
                'updated_at' => $subscription_usage->updated_at,
                'deleted_at' => $subscription_usage->deleted_at,
            ];
        }


        $data = [
            'id' => $this->id,
            'subscriber_type' => $this->subscriber_type,
            'subscriber_id' => User::find($this->subscriber_id,['id','first_name', 'last_name', 'company_name', 'country', 'email' , 'phone']),
            'plan_id' => app('rinvex.subscriptions.plan')->find($this->plan_id),
            'slug' => $this->slug,
            'name' => $this->getTranslations('name'),
            'description' => $this->getTranslations('description'),
            'trial_ends_at' => $this->trial_ends_at,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'cancels_at' => $this->cancels_at,
            'canceled_at' =>  $this->canceled_at,
            'timezone' => $this->timezone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'usages' => $usages,
        ];
        return $data;
    }
}
