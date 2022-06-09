<?php

namespace Modules\Mail\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'receivers' => json_decode($this->receivers,true ),
            'subject'=> $this->subject,
            'body_en' => $this->body_en,
            'body_ar'=> $this->body_ar,
            'sent_time'=> $this->sent_time,
            'scheduled'=> $this->scheduled,
            'receiver_type'=> $this->receiver_type
        ];
        return $data;    }
}
