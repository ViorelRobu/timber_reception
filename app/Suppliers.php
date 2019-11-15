<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Countries;
use App\SupplierGroup;
use App\SupplierStatus;
use OwenIt\Auditing\Contracts\Auditable;


class Suppliers extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    
    public function countryOfResidence()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }
    public function supplierGroup()
    {
        return $this->belongsTo(SupplierGroup::class, 'supplier_group_id');
    }
    public function supplierStatus()
    {
        return $this->belongsTo(SupplierStatus::class, 'supplier_status_id');
    }
}
