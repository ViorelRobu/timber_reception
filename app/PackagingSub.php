<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PackagingSub extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $guarded = [];
    protected $table = 'packaging_subgroup';
}
