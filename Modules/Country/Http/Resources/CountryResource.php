<?php

namespace Modules\Country\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            "title_en" => $this->title_en,
            "title_ar" => $this->title_ar,
            'code' => $this->code,
            'flag' => $this->flag,
            'phone_prefixes' => json_decode($this->phone_prefixes,true)
        ];
        return $data;
    }
}
