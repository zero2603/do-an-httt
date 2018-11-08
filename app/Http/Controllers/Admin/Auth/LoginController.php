<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller
{
    public function index()
    {
    	return view('admin.auth.login');
    }

    public function login(Request $request) {

        if(Auth::attempt(['email' => $request['email'], 'password' => $request['password'],'is_admin' => 1])) {
            return redirect('/admin');
        }else{
            return redirect('/admin/login')->withErrors('Email hoặc mật khẩu không hợp lệ');
        }
    }
}
