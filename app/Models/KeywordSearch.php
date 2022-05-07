<?php

namespace App\Models;

use App\Models\OrganicResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KeywordSearch extends Model
{
    use SoftDeletes;
    
    protected $table = 'keyword_search';
    public $timestamps = true;

    public function organic(): HasMany
    {
        return $this->hasMany(OrganicResult::class, 'keyword_id');
    }

    public function relatedSearch(): HasMany
    {
        return $this->hasMany(RelatedSearch::class, 'keyword_id');
    }

}

