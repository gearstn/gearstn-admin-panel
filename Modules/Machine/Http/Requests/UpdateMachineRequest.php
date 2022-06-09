<?php

namespace Modules\Machine\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMachineRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'year' => 'required',
            'sn' => 'required',
            'description' => 'required',
            'condition' => 'required',
            'sell_type' => 'required',
            'seller_id' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'manufacture_id' => 'required',
            'model_id' => 'required_without:new_model',
            'city_id' => 'sometimes',
            'new_model' => 'required_without:model_id',
//            'manufacturing_place' => 'required|string',
            'slug' => 'sometimes',
            'sku' => 'sometimes',
            'report_file' => 'required_if:manufacturing_place,forign',
            "photos" => ["required","array","min:1","max:5"],
            "photos.*" => ["required","mimes:jpeg,jpg,png,gif,webp","max:1000"],
            "videos" => ["array","min:0","max:3"],
            "serial_photo" => ["mimes:jpeg,jpg,png,gif,webp","max:1000"],
            "hour_meter_photo" => ["mimes:jpeg,jpg,png,gif,webp","max:1000"],
            "videos" => ["array","min:1","max:5"],
            "country_id" => 'required'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
