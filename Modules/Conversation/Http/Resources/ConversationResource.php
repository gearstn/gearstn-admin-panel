<?php

namespace Modules\Conversation\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Machine\Entities\Machine;
use Modules\SparePart\Entities\SparePart;

class ConversationResource extends JsonResource
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
            "id" => $this->id,
            "chat_token" => $this->chat_token,
            "acquire_done" => $this->acquire_done,
            "owner_done" => $this->owner_done,
            "acquire" => User::find($this->acquire_id,['id','first_name', 'last_name']),
            "owner" => User::find($this->owner_id,['id','first_name', 'last_name']),
            'model_type' =>$this->model_type
        ];
        if($this->model_type == 'Machine'){
            $data['product'] = Machine::find( $this->model_id ,['id','slug']);

        }
        else{
            $data['product'] = SparePart::find( $this->model_id ,['id','slug']);
        }

        return $data;
    }
}
