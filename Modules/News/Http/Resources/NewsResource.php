<?php

namespace Modules\News\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Upload\Entities\Upload;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            "id" => $this->id,
            "title_en" => $this->title_en,
            "title_ar" => $this->title_ar,
            "post_date" => $this->post_date,
            "updated_date" => $this->updated_at,
            "created_date" => $this->created_at,
            "image_id" => Upload::find($this->image_id,['id', 'url']),
            "bodytext_en" => $this->bodytext_en,
            "bodytext_ar" => $this->bodytext_ar,
            "slug" => $this->slug,
            "mins_read" => $this->mins_read,
            "author_en" => $this->author_en,
            "author_ar" => $this->author_ar,
            "seo_title_en" => $this->seo_title_en,
            "seo_title_ar" => $this->seo_title_ar,
            "seo_description_en" => $this->seo_description_en,
            "seo_description_ar" => $this->seo_description_ar,
        ];
        return $data;
    }
}
