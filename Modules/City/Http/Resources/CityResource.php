<?php

namespace Modules\City\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Country\Entities\Country;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            "id" => $this->id,
            "title_en" => $this->title_en,
            "title_ar" => $this->title_ar,
            "country_id" => Country::find($this->country_id,['id','title_en'])
        ];
        return $data;
    }
}
