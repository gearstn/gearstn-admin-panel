<?php

namespace Modules\User\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Country\Entities\Country;
use Modules\Upload\Entities\Upload;
use Spatie\Permission\Models\Role;

class FullUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'company_name' => $this->company_name,
            'email' => $this->email,
            'tax_license' => $this->tax_license,
            'tax_license_image' => Upload::find($this->tax_license_image,['id', 'url']),
            'commercial_license' => $this->commercial_license,
            'commercial_license_image' => Upload::find($this->commercial_license_image,['id', 'url']),
            'national_id' => $this->national_id,
            'national_id_image' => Upload::find($this->national_id_image,['id', 'url']),
            "country_id" => Country::find($this->country_id,['id','title_en']),
            'phone' => $this->phone,
            'role_id' => Role::find($this->roles->pluck('id'),['id','name']),
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at
        ];

        if ($this->hasRole('distributor') ) {
            unset($data['national_id'] ,$data['national_id_image']);
        }
        elseif ($this->hasRole('contractor')) {
            unset($data['tax_license'] ,$data['tax_license_image'],$data['commercial_license'],$data['commercial_license_image']);
        }
        return $data;
    }
}
