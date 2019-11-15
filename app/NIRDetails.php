<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class NIRDetails extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'nir_details';
    protected $guarded = [];
}
