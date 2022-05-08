<?php

namespace App;

use App\Models\KeywordSearch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class JSVars
{
    private const SECONDS = '18000';

    public static function getKeywords(): string
    {
        $keywords = KeywordSearch::pluck('keywords')->toArray();

        $encoded = json_encode($keywords);
        $encoded = addslashes($encoded);

        return $encoded;
    }
}