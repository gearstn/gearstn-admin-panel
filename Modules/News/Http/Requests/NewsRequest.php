<?php

namespace Modules\News\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'post_date' => 'required',
            'image_id' => 'required',
            'bodytext_en' => 'required',
            'bodytext_ar' => 'required',
            'slug' => 'string',
            'mins_read' => 'integer',
            'author_en' => 'string',
            'author_ar' => 'string',
            'seo_title_en' => 'string',
            'seo_title_ar' => 'string',
            'seo_description_en' => 'string',
            'seo_description_ar' => 'string',
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
