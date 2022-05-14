<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\KeywordSearch;

class UserSearch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'keywords',
        'status',
        'keyword_search_id',
    ];
    
    public function keyword_search()
    {
        return $this->belongsTo(KeywordSearch::class, 'keyword_search_id');
    }
}
