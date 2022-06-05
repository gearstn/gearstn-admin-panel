<?php

namespace Modules\Upload\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UploadResource extends JsonResource
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
            'user_id' => $this->user_id,
            'file_original_name' => $this->file_original_name,
            'extension' => $this->extension,
            'file_size' => $this->file_size,
            'file_name' => $this->file_name,
            'type' => $this->type,
            'url' => $this->url,
            'file_path' => $this->file_path,
        ];
        return $data;
    }
}
