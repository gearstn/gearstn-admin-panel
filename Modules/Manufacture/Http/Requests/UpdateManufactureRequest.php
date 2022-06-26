<?php

namespace Modules\Manufacture\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManufactureRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title_en' => 'required',
            'title_ar' => 'required',
            'category_id' => 'required',
            'sub_categories' => 'sometimes',
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
