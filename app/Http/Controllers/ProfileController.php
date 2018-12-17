<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Users;
use Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
	function index() {
		$user = Auth::user();
		return view('user.profile.profile', ['user' => $user]);
	}
	
	function edit() {
		$user = Auth::user();
		return view('user.profile.edit', ['user' => $user]);
	}
}