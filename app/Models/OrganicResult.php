<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganicResult extends Model
{
    use SoftDeletes;
    
    protected $table = 'organic_result';
    public $timestamps = true;

}

