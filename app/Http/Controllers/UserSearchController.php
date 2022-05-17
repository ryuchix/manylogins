<?php

namespace App\Http\Controllers;

use App\Models\UserSearch;
use Illuminate\Http\Request;

class UserSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_searches = UserSearch::when($request->status, function($query) use ($request) {
                            if ($request->status == 1) {
                                $query->where('status', '=', 1); 
                            } elseif ($request->status == 2) {
                                $query->where('status', NULL); 
                            }
                        })->when($request->search, function($query) use ($request) {
                            $query->where('keywords', 'LIKE', "%{$request->search}%"); 
                        })->paginate(30);

        return view('admin.user-searches.index', ['user_searches' => $user_searches]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
