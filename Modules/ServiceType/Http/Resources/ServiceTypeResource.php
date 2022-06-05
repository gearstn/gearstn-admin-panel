<?php

namespace Modules\ServiceType\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data =[
            'id' => $this->id,
            'title_en' => $this->title_en,
            'title_ar' => $this->title_ar,
        ];
        return $data;
    }
}
