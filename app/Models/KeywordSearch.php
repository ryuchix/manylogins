<?php

namespace App\Models;

use App\Models\OrganicResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class KeywordSearch extends Model implements Viewable
{
    use SoftDeletes, InteractsWithViews;
    
    protected $table = 'keyword_search';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'keywords',
        'slug',
        'status',
        'api_result',
    ];

    public function organic(): HasMany
    {
        return $this->hasMany(OrganicResult::class, 'keyword_id');
    }

    public function relatedSearch(): HasMany
    {
        return $this->hasMany(RelatedSearch::class, 'keyword_id');
    }

}

