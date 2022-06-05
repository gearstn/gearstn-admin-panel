<?php

namespace Modules\MachineModel\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MachineModelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            "id" => $this->id,
            "title_en" => $this->title_en,
            "title_ar" => $this->title_ar,
            "category_id" => $this->category_id,
            "sub_category_id" => $this->sub_category_id,
            "manufacture_id" => $this->manufacture_id,
        ];
        return $data;
    }
}
