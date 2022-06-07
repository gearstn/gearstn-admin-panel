<?php

namespace Modules\SparePart\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City;
use Modules\Country\Entities\Country;
use Modules\Manufacture\Entities\Manufacture;
use Modules\SparePart\Entities\SparePart;
use Modules\SparePartModel\Entities\SparePartModel;
use Modules\SubCategory\Entities\SubCategory;
use Modules\Upload\Entities\Upload;

class SparePartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $selected_columns = ['id','title_en','title_ar'];
        $data = [
            "id" => $this->id,
            'description' => $this->description,
            'country' => Country::find($this->country_id,$selected_columns),
            'slug' => $this->slug,
            'images' => Upload::findMany(json_decode($this->images),['id', 'url']),
            'sku' => $this->sku,
            'price' =>  $this->price == null ? null :currency_converter('USD',$this->price),
            'is_original' => $this->is_original,
            'condition' => $this->condition,
            'approved' => $this->approved,
            'featured' => $this->featured,
            'verified' => $this->verified,
            'seller' => User::find($this->seller_id,['id','first_name', 'last_name', 'company_name', 'country', 'email' , 'phone']),
            'city' => City::find($this->city_id,$selected_columns),
            'category' => Category::find($this->category_id,$selected_columns),
            'sub_category' => SubCategory::find($this->sub_category_id,$selected_columns),
            'manufacture' => Manufacture::find($this->manufacture_id,$selected_columns),
            'views' => views(SparePart::find($this->id))->count()
        ];
        return $data;
    }
}
