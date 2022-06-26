<?php

namespace Modules\Service\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name' =>  'required',
            'address' => 'required',
            'description' => 'required',
            'user_id' => 'required',
            'approved' => 'required',
            'service_type_id' => 'required',
            'city_id' => 'sometimes',
            'country_id' => 'sometimes',
            "photos" => ["sometimes", "array", "min:1", "max:1"],
            "photos.*" => ["sometimes", "mimes:jpeg,jpg,png,gif,webp", "max:1000"],
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
