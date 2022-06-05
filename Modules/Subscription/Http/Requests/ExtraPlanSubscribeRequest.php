<?php

namespace Modules\Subscription\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExtraPlanSubscribeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'number_of_listing' => 'required',
            'photos_of_listing' => 'required',
            'number_of_months' => 'required',
            'starts_at' => 'required',
            'ends_at' => 'required',
            'machines' => 'required',
            'user_id' => 'required'
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
