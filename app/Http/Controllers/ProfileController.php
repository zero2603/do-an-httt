<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Users;
use Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
	function index() {
		//check current user id??
		$id = Auth::id();
		$user = DB::table('users')->where('id','=', $id)->get();
		if(!isset($user[0])) {
			return;
		} else {
			$user[0]->info = $user[0]->address1.", ".$user[0]->town_city.", ".$user[0]->county.", ".$user[0]->country;
			return view('user.profile.profile', ['user' => $user[0]]);
		}
		
	}
	function edit() {
		//check current user id??
		$id = Auth::id();
		$user = DB::table('users')->where('id','=', $id)->get();
		$user = DB::table('users')->where('id','=', 1)->get();
		if(!isset($user[0])) {
			return;
		} else {
			$user[0]->info = $user[0]->address1.", ".$user[0]->town_city.", ".$user[0]->county.", ".$user[0]->country;
			return view('user.profile.edit', ['user' => $user[0]]);
		}
	}
}