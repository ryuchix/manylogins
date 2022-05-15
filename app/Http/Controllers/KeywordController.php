<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KeywordSearch;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $keywords = KeywordSearch::when($request->status, function($query) use ($request) {
                            if ($request->status == 1) {
                                $query->where('status', '=', 1); 
                            } elseif ($request->status == 2) {
                                $query->where('status', NULL); 
                            }
                        })->when($request->search, function($query) use ($request) {
                            $query->where('keywords', 'LIKE', "%{$request->search}%"); 
                        })->paginate(30);

        return view('admin.keywords.index', ['keywords' => $keywords]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function massDelete(Request $request)
    {
        $ids = explode(",", $request->ids);

        foreach ($ids as $id) {
            KeywordSearch::find($id)->delete();
        }

        return redirect()->back()->with('success', 'Keywords deleted successfully.');
    }
}
