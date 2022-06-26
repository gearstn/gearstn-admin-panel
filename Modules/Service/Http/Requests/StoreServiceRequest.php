<?php

namespace Modules\Service\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\DatabaseRule;
class StoreServiceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name' =>  [
                'required',
                Rule::unique('services')->where(function ($query) {
                    return $query->where('company_name', $this->company_name)
                    ->where('service_type_id', $this->service_type_id);
                })
            ],
             'address' => 'required',
             'approved' => 'required',
            'description' => 'required',
            'user_id' => 'required',
            'service_type_id' => 'required',
            'city_id' => 'sometimes',
            'country_id' => 'sometimes',
            "photos" => ["required","array","min:1","max:1"],
            "photos.*" => ["required","mimes:jpeg,jpg,png,gif,webp","max:1000"],
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
