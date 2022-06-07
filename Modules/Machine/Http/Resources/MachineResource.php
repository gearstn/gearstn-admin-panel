<?php

namespace Modules\Machine\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City;
use Modules\MachineModel\Entities\MachineModel;
use Modules\Manufacture\Entities\Manufacture;
use Modules\SubCategory\Entities\SubCategory;
use Modules\Upload\Entities\Upload;
use AmrShawky\LaravelCurrency\Facade\Currency;
use Illuminate\Support\Facades\Config;
use Modules\Country\Entities\Country;
use Modules\Machine\Entities\Machine;

class MachineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $selected_columns = ['id','title_en','title_ar'];
        $data = [
            "id" => $this->id,
            'year' => $this->year,
            'sn' => $this->sn,
            'condition' => $this->condition,
            'hours' => $this->hours,
            'description' => $this->description,
            'sell_type' => $this->sell_type,
            'rent_hours' => $this->rent_hours,
            'slug' => $this->slug,
            'images' => Upload::findMany(json_decode($this->images),['id', 'url']),
            'sku' => $this->sku,
            'price' =>  $this->price == null ? null :currency_converter('USD',$this->price),
            'approved' => $this->approved,
            'featured' => $this->featured,
            'verified' => $this->verified,
            'seller' => User::find($this->seller_id,['id','first_name', 'last_name', 'company_name', 'country', 'email' , 'phone']),
            'country' => Country::find($this->country_id,$selected_columns),
            'city' => City::find($this->city_id,$selected_columns),
            'category' => Category::find($this->category_id,$selected_columns),
            'sub_category' => SubCategory::find($this->sub_category_id,$selected_columns),
            'manufacture' => Manufacture::find($this->manufacture_id,$selected_columns),
            'model' => MachineModel::find($this->model_id,$selected_columns),
            'views' => views(Machine::find($this->id))->count(),
            'phone_clicks' => $this->phone_clicks,
            'videos' => Upload::findMany(json_decode($this->videos),['id', 'url']),
        ];
        return $data;
    }
}
