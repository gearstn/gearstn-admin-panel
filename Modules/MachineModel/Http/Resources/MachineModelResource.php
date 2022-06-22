<?php

namespace Modules\MachineModel\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Entities\Category;
use Modules\Manufacture\Entities\Manufacture;
use Modules\SubCategory\Entities\SubCategory;

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
        $selected_columns = ['id','title_en'];
        $data = [
            "id" => $this->id,
            "title_en" => $this->title_en,
            "title_ar" => $this->title_ar,
            "category_id" => Category::find($this->category_id ,$selected_columns),
            "sub_category_id" => SubCategory::find($this->sub_category_id,$selected_columns),
            "manufacture_id" => Manufacture::find($this->manufacture_id,$selected_columns),
        ];
        return $data;
    }
}
