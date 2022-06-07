<?php

namespace Modules\Transaction\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Transaction\Entities\OrderStatus;

class TransactionResource extends JsonResource
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
            'type' => $this->type ,
            'referenceNumber' => $this->referenceNumber ,
            'merchantRefNumber' => $this->merchantRefNumber ,
            'orderAmount' => $this->orderAmount ,
            'paymentAmount' => $this->paymentAmount ,
            'fawryFees' => $this->fawryFees ,
            'orderStatus' => $this->orderStatus ,
            'paymentMethod' => $this->paymentMethod ,
            'paymentTime' => $this->paymentTime ,
            'customerName' => $this->customerName ,
            'customerMobile' => $this->customerMobile ,
            'customerMail' => $this->customerMail ,
            'taxes' => $this->taxes ,
            'statusCode' => $this->statusCode ,
            'statusDescription' => $this->statusDescription ,
            'basketPayment' => $this->basketPayment ,
            'fawry_order_status' => OrderStatus::select('name_en','name_ar')->where('id',$this->fawry_order_status_id)->first(),
            'user_id' => $this->user_id
        ];
        return $data;
    }
}
