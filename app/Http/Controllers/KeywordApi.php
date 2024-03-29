<?php

namespace App\Http\Controllers;

use App\Models\KeywordSearch;
use App\Models\OrganicResult;
use App\Models\RelatedSearch;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class KeywordApi
{
    public static function searchKeywords($keywords): ?array
    {
        if ($keywords != null) {
            $response = Http::withBasicAuth(
                config('serpmaster.serp_master_username'),
                config('serpmaster.serp_master_password')
            )->post(
                'https://rt.serpmaster.com/', 
                [
                'q' => $keywords,
                'parse' => true,
                ]
            );
                            
            return ($response->successful()) ? $response->json() : null;
        }
    }

    public static function serpKeywords($int)
    {
        $keywords = KeywordSearch::limit($int)
            ->where('status', '=', null)
            ->get();
     
        $keywords->each(
            function ($item, $key) {
                $result = self::searchKeywords($item->keywords);
                self::updateKeywords($item->id, json_encode($result));
            }
        );

        return $keywords->toArray();
    }

    public static function serpKeywordsCommands($int)
    {
        $keywords = KeywordSearch::offset(0)->limit($int)
            ->select('status', 'api_result', 'keywords', 'slug', 'id')
            ->where('status', NULL)
            ->where('api_result', NULL)
            ->get();

        $keywords->each(
            function ($item, $key) {
                $result = self::searchKeywords($item->keywords);
                if ($result != null) {
                    self::updateKeywords($item->id, $item->keywords, $result);
                }
            }
        );
    }

    public static function serpRelatedKeywordsCommands($int)
    {
        $keywords = RelatedSearch::offset(0)->limit($int)
            ->select('status', 'keyword_id', 'keywords', 'id')
            ->where('status', 2)
            ->get();

        $keywords->each(
            function ($item, $key) {
                $keywords_search = KeywordSearch::where('slug', self::clean($item->keywords))->first();
                if (empty($keywords_search)) {
                    $result = self::searchKeywords($item->keywords);
                    if ($result != null) {
                        self::updateRelatedKeywords($item->id, $item->keywords, $result, $item->keyword_id);
                    } else {
                        $keyword = RelatedSearch::find($item->id);
                        $keyword->status = 1;
                        $keyword->save();
                    }
                } else {
                    $keyword = RelatedSearch::find($item->id);
                    $keyword->status = 1;
                    $keyword->save();
                }
            }
        );
    }

    public static function updateRelatedKeywords($id, $keywords, $result, $keyword_id) 
    {
        $keyword = RelatedSearch::find($id);
        $keyword->status = 1;
        $keyword->save();

        $keyword_search = KeywordSearch::create([
            'keywords' => $keywords,
            'slug' => self::clean($keywords),
            'api_result' => json_encode($result),
            'status' => 1
        ]);

        self::insertOrganicResult($keyword_search->id, $result);
    }

    public static function updateKeywords($id, $slug, $result) 
    {
        $keyword = KeywordSearch::find($id);
        $keyword_search = KeywordSearch::find($id);
        $keyword_search->slug = self::clean($slug);
        $keyword_search->api_result = json_encode($result);
        $keyword_search->status = 1;
        $keyword_search->save();

        self::insertOrganicResult($keyword_search->id, $result);
    }

    public static function clean($string)
    {
        $string = str_replace(' ', '-', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
    }

    public static function insertOrganicResult($id, $result) 
    {   
        if ($result != null && !is_null($result['results'][0])) {
            $content = collect($result['results'][0]['content']['results']);
            $organic = collect($content['organic']);

            $organic_insert = collect();
            $organic->each(
                function ($item, $key) use ($id, $organic_insert) {
                    $organic_insert->push(
                        [
                            'keyword_id' => $id,
                            'pos'=> $item['pos'],
                            'url'=> $item['url'],
                            'desc'=> $item['desc'],
                            'title'=> $item['title'],
                            'url_shown'=> $item['url_shown'],
                            'pos_overall'=> $item['pos_overall'],
                        ]
                    );
                }
            );

            OrganicResult::insert($organic_insert->toArray());
            self::insertRelatedSearches($id, $result);
        } 
    }

    public static function insertRelatedSearches($id, $result) 
    {
        if ($result != null && isset($result['results'][0]['content']['results']['related_searches'])) {
            $content = collect($result['results'][0]['content']['results']);
            $related = collect($content['related_searches']['related_searches']);

            $related_insert = collect();
            $related->each(
                function ($item, $key) use ($id, $related_insert) {
                    $exists = RelatedSearch::where('keyword_id', $id)
                                        ->where('keywords', $item)->exists();

                    $hasWords = strpos($item, 'login') !== false || strpos($item, 'portal') !== false;

                    if (!$exists && $hasWords) {
                        $related_insert->push(
                            [
                                'keyword_id' => $id,
                                'keywords'=> $item,
                            ]
                        );
                    }
                }
            );

            RelatedSearch::insert($related_insert->toArray());
        } 
    }
}
