<?php

namespace Modules\Transaction\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'fawry_transactions';

    protected $fillable =
    [
        'type',
        'referenceNumber',
        'merchantRefNumber',
        'orderAmount',
        'paymentAmount',
        'fawryFees',
        'orderStatus',
        'paymentMethod',
        'paymentTime',
        'customerName',
        'customerMobile',
        'customerMail',
        'taxes',
        'statusCode',
        'statusDescription',
        'basketPayment',
        'fawry_order_status_id',
        'user_id'
    ];
}
