<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\KeywordApi;

use App\Models\KeywordSearch;
use App\Models\OrganicResult;
use App\Models\UserSearch;
use App\Models\Setting;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use Hashids\Hashids;

class PublicController extends Controller
{
    public function home()
    {
        $setting = Setting::find(1);
        
        return view('home.home', ['setting' => $setting]);
    }

    public function search(Request $request)
    {   
        $search = $request->search;
        $search_result = null;
        $meta_keywords = '';
        $keywords = KeywordSearch::with('organic')
            ->with('relatedSearch')
            ->where('status', 1)
            ->when(
                $request->search, 
                function ($query, $search) {
                    $query->where('slug', $search);
                }
            )
            ->get();

        if ($keywords->count() === 0) {
            
        } else {
            if ($keywords->first()->organic->count() >= 1) {
                $search_result = $keywords->first();
            }

            $keywords_related = [];

            if ($search_result != null) {
                $keywords_related = $search_result
                    ->relatedSearch
                    ->pluck('keywords')
                    ->toArray();

                array_unshift($keywords_related, $search_result->keywords);

                $meta_keywords = implode(
                    ',',
                    $keywords_related
                );
            }
        }

        $setting = Setting::find(1);

        $bannedWords = explode(',', trim($setting->banned_keywords));

        $title = (str_replace('-', ' ', $search));

        $checker = [];

        foreach ($bannedWords as $key => $bannedWord) {
            $checker[] = str_contains($title, trim($bannedWord));
        }

        if ($search_result == null && !in_array(true, $checker)) {
            UserSearch::firstOrCreate([
                'keywords' => $title
            ]);
        }
        
        return view('home.search', [
            'title' => ($title ?? ''),
            'setting' => $setting,
            'search_result' => $search_result,
            'search' => $search,
            'keyword' => strip_tags($meta_keywords),
            'description' => strip_tags($search_result->keywords ?? '')
        ]);
    }

    public function visitPage(Request $request)
    {
        $result_link = null;
        
        $hashids = new Hashids();

        $visit = $request->visit;
        if ($hashids->decode($request->cid) != null) {
            $result = OrganicResult::find($hashids->decode($request->cid)[0]);
        } else {
            return redirect()->back();
        }
		
		if ($result->first()->count() >= 1) {
			$result_link = $result->first();
        }
		
        $setting = Setting::find(1);

        return view('home.show', [
            'title' => ucfirst($result->title),
            'setting' => $setting,
            'result_link' => $result_link,
            'result' => $result,
            'visit' => $visit,
            'keyword' => strip_tags(str_replace(' ', ',', $result->desc)),
            'description' => strip_tags($result->desc)
        ]);


    }

    public function keywordSearch(Request $request)
    {
        $query = $request->search;
        $filterResult = KeywordSearch::where('keywords', 'LIKE', '%'.$query.'%')
            ->where('status', 1)
            ->take(20)
            ->get(['slug', 'keywords']);

        return response()->json($filterResult);
    }
}
