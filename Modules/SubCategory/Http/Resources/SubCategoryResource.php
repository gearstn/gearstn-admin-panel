<?php

namespace Modules\SubCategory\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Entities\Category;
use Modules\Manufacture\Http\Resources\ManufactureResource;

class SubCategoryResource extends JsonResource
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
            "category_id" => Category::find($this->category_id,['id','title_en']),
            'manufactures' => $this->manufactures()->get(['id', 'title_en']),
        ];
        return $data;
    }
}
