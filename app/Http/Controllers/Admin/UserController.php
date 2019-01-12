<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use \App\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->all();
        unset($query['_token']);

        if(array_key_exists ('name', $query)) {
            $name = $query['name'];
            unset($query['name']);
            $users = User::where('is_admin', 0)
                ->where($query)
                ->where('first_name', 'LIKE', '%'.$name.'%')
                ->orWhere('last_name', 'LIKE', '%'.$name.'%')
                ->paginate(10);
        } else {
            $users = User::where('is_admin', 0)->where($query)->paginate(10);
        }

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', ['user' => $user]);
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
        $data = request()->except(['_token', '_method']);

        foreach($data as $key => $value) {
            $user->$key = $value;
        }
        $user->save();
        return redirect('admin/users');
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
        if(!$user->is_admin) {
            $user->delete();
        } 
        
        return redirect('admin/users');
    }
}
