<?php

namespace Modules\SparePart\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SparePartUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required',
            'slug' => 'sometimes',
            'condition' => 'required',
            'seller_id' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'manufacture_id' => 'sometimes',
            'city_id' => 'sometimes',
            'sku' => 'sometimes',
            'price' => 'sometimes',
            "photos" => ["sometimes","array","min:1","max:5"],
            "photos.*" => ["sometimes","mimes:jpeg,jpg,png,gif,webp","max:1000"],
            'country_id' => 'required',
            'is_original' => 'required',
            'approved' => 'required',
            'featured' => 'required',
            'verified' => 'required',
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
