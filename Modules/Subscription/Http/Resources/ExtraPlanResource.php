<?php

namespace Modules\Subscription\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExtraPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'name' => $this->name,
            'number_of_listing' => $this->number_of_listing,
            'photos_of_listing' => $this->photos_of_listing,
            'number_of_months' => $this->number_of_months,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'machines' => $this->machines,
            'user_id' => $this->user_id,
        ];
        return $data;
    }
}
