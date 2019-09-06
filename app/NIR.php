<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NIR extends Model
{
    protected $table = 'nir';
    protected $guarded = [];
    protected $dates = [
        'data_nir',
        'data_dvi',
        'data_aviz'
    ];
}
