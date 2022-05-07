<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\KeywordApi;

use App\Models\KeywordSearch;
use App\Models\OrganicResult;

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
        $keywords = KeywordSearch::with('organic')
            ->with('relatedSearch')
            ->when(
                $request->search, 
                function (Builder $query) use ($search) {
                    $query->where('slug', $search);
                }
            )
            ->get();

        if ($keywords->count() === 0) {
            abort(404);
        }

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

        // $data = Pages::getPage('search');
   
        // return $this->response
        //     ->setMetaKeyword(strip_tags($meta_keywords))
        //     ->setMetaDescription(strip_tags($data['meta_description']))
        //     ->setMetaTitle(strip_tags(ucfirst($search_result->keywords)))
        //     ->layout('home')
        //     ->view('search')
        //     ->data(compact('data', 'search_result', 'request'))
        //     ->output();
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
