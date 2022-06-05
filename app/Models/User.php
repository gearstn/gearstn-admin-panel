<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\PasswordReset;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use LamaLama\Wishlist\HasWishlists;
use Modules\Machine\Entities\Machine;
use Modules\Service\Entities\Service;
use Modules\Subscription\Entities\Subscription;
use Spatie\Permission\Traits\HasRoles;
use Rinvex\Subscriptions\Traits\HasSubscriptions;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens , SoftDeletes, HasWishlists , HasRoles, HasSubscriptions;

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'company_name',
        'email',
        'password',
        'tax_license',
        'tax_license_image',
        'commercial_license',
        'commercial_license_image',
        'country',
        'is_admin',
        'panned',
        'phone',
        'national_id',
        'national_id_image',
        'country_id',
        'city_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];


    public static $cast = [
        'first_name' => 'required',
        'last_name' => 'required',
        // 'company_name' => 'required',
        'email' => 'required|unique:users',
        'tax_license' => 'required|unique:users',
        'commercial_license' => 'required|unique:users',
        'role_id' => 'required',
        'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
    ];

    public function machines()
    {
        return $this->hasMany(Machine::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }


    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }

    protected static function newFactory()
    {
        //return \Modules\User\Database\factories\UserFactory::new();
    }
}
