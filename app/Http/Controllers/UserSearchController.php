<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\KeywordSearch;
use App\Models\UserSearch;
use Session;

class UserSearchController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin|manager']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->status ?? 2;

        $user_searches = UserSearch::when($status, function($query) use ($request) {
                            if ($request->status == 1) {
                                $query->where('status', '=', 1); 
                            } elseif ($request->status == 3) {
                                $query->where('status', 3); 
                            } else {
                                $query->where('status', 2); 
                            }
                        })->when($request->search, function($query) use ($request) {
                            $query->where('keywords', 'LIKE', "%{$request->search}%"); 
                        })
                        ->paginate(30);

        return view('admin.user-searches.index', ['user_searches' => $user_searches]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user-searches.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        session()->forget('banned');
        session()->forget('duplicate');

        $keywords = $request->keywords;

        $keywords = trim(preg_replace('/\s+/', ' ', str_replace(', ', ',', $keywords)));

        $keywordsArray = explode(",", $keywords);

        $setting = Setting::find(1);

        $bannedWords = explode(',', trim($setting->banned_keywords));

        $banned = [];
        $duplicate = [];

        foreach ($keywordsArray as $key => $item) {
            $checker = [];

            foreach ($bannedWords as $key => $bannedWord) {
                if (str_contains($item, trim($bannedWord))) {
                    $banned[] = $item;
                }
                $checker[] = str_contains($item, trim($bannedWord));
            }

            if (!in_array(true, $checker)) {
                $user_search = KeywordSearch::where('keywords', $item)->first();
                $usersearch = UserSearch::where('keywords', $item)->first();

                if (!empty($user_search)) {
                    $duplicate[] = $item;
                } else {
                    if (!empty($usersearch)) {
                        $duplicate[] = $item;
                    } else {
                        UserSearch::firstOrCreate([
                            'keywords' => $item,
                            'status' => 2
                        ]);
                    }
                }
            }
        }

        if (count($banned) > 0) {
            Session::flash('banned', $banned);
        }

        if (count($duplicate) > 0) {
            Session::flash('duplicate', $duplicate);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserSearch  $userSearch
     * @return \Illuminate\Http\Response
     */
    public function show(UserSearch $userSearch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserSearch  $userSearch
     * @return \Illuminate\Http\Response
     */
    public function edit(UserSearch $userSearch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserSearch  $userSearch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserSearch $userSearch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserSearch  $userSearch
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSearch $userSearch)
    {
        //
    }

    public function massUpdate(Request $request)
    {
        $ids = explode(",", $request->ids);
        $status = $request->status;

        foreach ($ids as $id) {
            UserSearch::where('id', $id)->update([
                'status' => $status
            ]);
        }

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
