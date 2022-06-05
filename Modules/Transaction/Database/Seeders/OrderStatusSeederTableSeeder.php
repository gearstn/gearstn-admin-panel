<?php

namespace Modules\Transaction\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Transaction\Entities\OrderStatus;

class OrderStatusSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status1 = ['name_en'=>'PAID','name_ar'=>'تم الدفع'];
        $status2 = ['name_en'=>'UNPAID','name_ar'=>'غير مدفوع'];
        $status3 = ['name_en'=>'REFUNDED','name_ar'=>'معاد'];
        $status4 = ['name_en'=>'SUCCESS','name_ar'=>'نجح'];
        $status5 = ['name_en'=>'FAILD','name_ar'=>'فشل'];
        $status6 = ['name_en'=>'TIMEOUT','name_ar'=>'نفذ الوقت'];
        $status7 = ['name_en'=>'CANCELED','name_ar'=>'ألغيت'];
        $status8 = ['name_en'=>'EXPIRED','name_ar'=>'منتهية الصلاحية'];
        OrderStatus::create($status1);
        OrderStatus::create($status2);
        OrderStatus::create($status3);
        OrderStatus::create($status4);
        OrderStatus::create($status5);
        OrderStatus::create($status6);
        OrderStatus::create($status7);
        OrderStatus::create($status8);
    }
}
