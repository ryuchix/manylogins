<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\KeywordSearch;

class RelatedSearch extends Model
{
    use SoftDeletes;
    
    protected $table = 'related_search';
    public $timestamps = true;

    public function keyword_search()
    {
        return $this->belongsTo(KeywordSearch::class, 'keyword_id');
    }

}

