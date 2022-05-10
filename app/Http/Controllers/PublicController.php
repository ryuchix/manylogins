<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\KeywordApi;

use App\Models\KeywordSearch;
use App\Models\OrganicResult;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use Hashids\Hashids;

class PublicController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $search_result = null;
        $meta_keywords = '';
        $keywords = KeywordSearch::with('organic')
            ->with('relatedSearch')
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

        $title = (str_replace('-', ' ', $search));
        
        return view('search', [
            'title' => ($title ?? ''),
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
		
        return view('show', [
            'title' => ucfirst($result->title),
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

    public function test($test)
    {
        try {
            $response = Http::withBasicAuth(
                config('serpmaster.serp_master_username'),
                config('serpmaster.serp_master_password')
            )->post(
                'https://rt.serpmaster.com/', 
                [
                'q' => $test,
                'parse' => true,
                ]
            );
                            
            return ($response->successful()) ? $response->json() : null;
        } catch (\InvalidArgumentException $th) {
            logger('payment page error ' . json_encode($th));
        } catch (\InvalidArgumentException $e) {
            logger('payment page error ' . json_encode($e));
        }
    }
}
