<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SupplierGroup extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'supplier_group';

    protected $guarded = [];
}
