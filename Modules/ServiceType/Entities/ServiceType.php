<?php

namespace Modules\ServiceType\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Service\Entities\Service;
class ServiceType extends Model
{
    use HasFactory;

    protected $table = 'service_types';

    protected $fillable = ['title_en', 'title_ar'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    protected static function newFactory()
    {
        // return \Modules\ServiceType\Database\factories\ServiceTypeFactory::new();
    }
}
