<?php

namespace Modules\Employee\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            "name_en" => $this->name_en,
            "name_ar" => $this->name_ar,
            "image_url" => $this->image_url,
            "linkedin_url" => $this->linkedin_url,
        ];
        return $data;
    }
}
