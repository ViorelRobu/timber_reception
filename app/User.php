<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Countries;
use App\SupplierGroup;
use App\SupplierStatus;
use App\Suppliers;
use App\CompanyInfo;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function countriesCreator()
    {
        return $this->hasMany(Countries::class, 'user_id');
    }

    public function supplierGroupCreator()
    {
        return $this->hasMany(SupplierGroup::class, 'user_id');
    }

    public function supplierStatusCreator()
    {
        return $this->hasMany(SupplierStatus::class, 'user_id');
    }

    public function supplierCreator()
    {
        return $this->hasMany(Suppliers::class, 'user_id');
    }

    public function companyCreator()
    {
        return $this->hasMany(CompanyInfo::class, 'user_id');
    }
}
