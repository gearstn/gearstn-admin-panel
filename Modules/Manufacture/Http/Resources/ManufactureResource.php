<?php

namespace Modules\Manufacture\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Entities\Category;

class ManufactureResource extends JsonResource
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
            'sub-categories' => $this->sub_categories()->get(['id', 'title_en']),
        ];
        return $data;
    }
}
