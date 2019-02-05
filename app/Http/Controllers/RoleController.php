<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Gate;
use Kamaln7\Toastr\Facades\Toastr;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Gate::allows('isRoot')){
            $message = "No Permission";
            Toastr::error($message, $title = "Permission deny", $options = []);
            return back();
        }

        $roles = Role::all();
        return view('role.index',compact('roles'));
    }

    public function role_user_index()
    {
        if(!Gate::allows('isRoot')){
            $message = "No Permission";
            Toastr::error($message, $title = "Permission deny", $options = []);
            return back();
        }

        $users = User::all();
        $roles = Role::all();

        // dd($roles);
        return view('role_user.index',compact('roles','users'));
    }

    public function role_user_store(Request $request)
    {
        // return $request->all();
        $user_id    = $request['user_id'];
        $user       = User::find($user_id);

        $roleArray  = Role::find($request['role_id']);
        $user->roles()->sync($roleArray);

        $message = "Successfully add role to user";
        Toastr::success($message, $title = "Successfully Action", $options = []);

        $users = User::all();
        $roles = Role::all();

        return view('role_user.index',compact('roles','users'));

    }

    public function role_user_edit($id)
    {
        // dd($id);
        $userSelected = User::findOrFail($id);
        $users = User::all();
        $roles = Role::all();

        // dd($userSelected->roles);

        return view('role_user.edit',compact('roles','users','userSelected'));
    }

    public function role_user_update(Request $request, $id)
    {
        return $request->all();
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
        $validatedData = $request->validate([
            'title' => 'bail|required|unique:roles|max:255',
            'description' => 'required|max:255',
        ]);

        Role::create($request->all());

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('role.index',  compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role = Role::findOrFail($request->role_id);

        $role->update($request->all());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $role = Role::findOrFail($request->role_id);
        $role->delete();

        return back();
    }
}
