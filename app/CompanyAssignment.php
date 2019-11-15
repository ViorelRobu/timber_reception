<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CompanyAssignment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'company_assignment';
    protected $guarded = [];
}
