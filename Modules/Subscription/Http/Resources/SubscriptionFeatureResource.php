<?php

namespace Modules\Subscription\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionFeatureResource extends JsonResource
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
            "id" => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'value' => str_contains($this->slug, 'cost') ? currency_converter('EGP',(float)$this->value == null ? 0 : (float)$this->value ) : $this->value,
        ];
        return $data;
    }
}
