<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RelatedSearch;
use App\Models\KeywordSearch;

class RelatedSearchController extends Controller
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
        $related = RelatedSearch::query()->when($request->status, function($query) use ($request) {
                            if ($request->status == 1) {
                                $query->where('status', '=', 1); 
                            } elseif ($request->status == 2) {
                                $query->where('status', 2);
                            }
                        })->when($request->search, function($query) use ($request) {
                            $query->where('keywords', 'LIKE', "%{$request->search}%"); 
                        })->paginate(30);

        return view('admin.related.index', ['related' => $related]);
    }

    public function searchRelatedKeyword($id)
    {
        $keyword = KeywordSearch::find($id);

        if (!empty($keyword)) {
            $related = RelatedSearch::query()->where('keyword_id', $keyword->id)->paginate(30);
            
            // when($request->status, function($query) use ($request) {
            //                     if ($request->status == 1) {
            //                         $query->where('status', '=', 1); 
            //                     } elseif ($request->status == 2) {
            //                         $query->where('status', 2);
            //                     }
            //                 })->when($request->search, function($query) use ($request) {
            //                     $query->where('keywords', 'LIKE', "%{$request->search}%"); 
            //                 })->paginate(30);

            return view('admin.related.index', ['related' => $related]);
        }

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
            RelatedSearch::find($id)->delete();
        }

        return redirect()->back()->with('success', 'Keywords deleted successfully.');
    }

    public function massUpdate(Request $request)
    {
        $ids = explode(",", $request->ids);
        $status = $request->status;

        foreach ($ids as $id) {
            RelatedSearch::where('id', $id)->update([
                'status' => $status
            ]);
        }

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
