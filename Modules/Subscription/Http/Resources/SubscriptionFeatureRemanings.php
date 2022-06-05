<?php

namespace Modules\Subscription\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class SubscriptionFeatureRemanings extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $user = Auth::user();
        $plan = $user->subscriptions()->where('plan_id',$this->id)->first();

        if(str_contains($this->slug,'machine')){
            $subscription = app('rinvex.subscriptions.plan')->find($plan->plan_id);
            $subscription->features();
            $feature_slug_machines = null;
            $feature_slug_photos = null;
            $feature_slug_videos = null;
            foreach ($subscription->features as $feature) {
                if(str_contains($feature->slug , 'number-of-listing')) $feature_slug_machines = $feature->slug;
                if(str_contains($feature->slug , 'total-photos')) $feature_slug_photos = $feature->slug;
                if(str_contains($feature->slug , 'total-videos')) $feature_slug_videos = $feature->slug;
            }
            $data = [
                "usages_machines" => $plan->getFeatureUsage($feature_slug_machines),
                'usages_photos' => $plan->getFeatureUsage($feature_slug_photos),
                'usages_videos' => $plan->getFeatureUsage($feature_slug_videos),
                'starts_at' => $plan->starts_at,
                'ends_at' => $plan->ends_at,
            ];
        }
        else{
            $data = [
                'starts_at' => $plan->starts_at,
                'ends_at' => $plan->ends_at,
            ];
        }


        return $data;
    }
}
