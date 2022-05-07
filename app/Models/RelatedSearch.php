<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelatedSearch extends Model
{
    use SoftDeletes;
    
    protected $table = 'related_search';
    public $timestamps = true;

}

