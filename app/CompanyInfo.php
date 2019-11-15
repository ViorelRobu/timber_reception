<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CompanyInfo extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'company_info';

    protected $guarded = [];
}
