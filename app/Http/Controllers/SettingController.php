<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::find(1);

        return view('admin.settings.index', ['setting' => $setting]);
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
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $data = array_filter($request->all());

        $setting->update($data);

        if ($request->hasFile('footer_logo')) {
            $this->uploadImage($request->footer_logo, $setting->id, 'footer');
        }

        if ($request->hasFile('header_logo')) {
            $this->uploadImage($request->header_logo, $setting->id, 'header');
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }

    public function uploadImage($image, $id, $column)
    {
        $imageName = time().'.'.$image->extension();  
   
        $image->move(public_path('images/settings'), $imageName);

        $setting = Setting::find($id);
        if ($column == 'header') {
            $setting->header_logo = $imageName;
        }
        if ($column == 'footer') {
            $setting->footer_logo = $imageName;
        }
        $setting->save();
    }
}
