<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Countries;
use App\SupplierGroup;
use App\SupplierStatus;

class Suppliers extends Model
{
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
