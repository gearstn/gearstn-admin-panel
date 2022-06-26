<?php

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use App\Models\User;
use Modules\ServiceType\Entities\ServiceType;

class Service extends Model
{
    use Searchable;

    protected $table = 'services';
    protected $fillable = [
        'company_name',
        'address',
        'description',
        'approved',
        'user_id',
        'service_type_id',
        'country_id',
        'city_id',
        'images'
    ];

    //User how want to sell a machine
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //User how want to sell a machine
    public function service_type()
    {
        return $this->belongsTo(ServiceType::class);
    }

        /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'company_name' => $this->company_name,
            'address' => $this->address,
            'description' => $this->description,
            'service_type_title_en' => $this->service_type['title_en'],
            'service_type_title_ar' => $this->service_type['title_ar'],
        ];
    }


    protected static function newFactory()
    {
        // return \Modules\Service\Database\factories\ServiceFactory::new();
    }
}
