<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SupplierStatus extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'supplier_status';

    protected $guarded = [];
}
