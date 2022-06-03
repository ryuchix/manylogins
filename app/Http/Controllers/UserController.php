<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use App\Models\Role;
use DB;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();

        return view('admin.users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);
           
        $data = $request->all();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password'])
        ]);

        $user->assignRole($request->role);
         
        return redirect()->route('users.index')->with('success', 'User created successfully.');
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
        $user = User::find($id);

        $roles = Role::get();

        return view('admin.users.edit', ['user' => $user, 'roles' => $roles]);
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
        $user = User::find($id);

        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'password' => 'nullable|min:8',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048'
        ]);

        $permission_roles = DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        $user->assignRole($request->role);

        $data = array_filter($request->all());

        $user->update($data);

        if ($request->hasFile('image')) {
            $this->imageUpload($request->image, $id);
        }
         
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!empty($user)) {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        }
        
        return redirect()->route('users.index')->with('error', 'An error has occured.');
    }

    public function imageUpload($image, $id)
    {
        $imageName = time().'.'.$image->extension();  
   
        $image->move(public_path('images/users'), $imageName);

        $user = User::find($id);
        $user->image = $imageName;
        $user->save();
    }
}
