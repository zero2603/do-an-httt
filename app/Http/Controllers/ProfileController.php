<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Users;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
	function index() {
		//check current user id??

		$user = DB::table('users')->where('id','=', 1)->get();
		// print_r($user[0]->id);die();
		$user[0]->info = $user[0]->address1.", ".$user[0]->town_city.", ".$user[0]->county.", ".$user[0]->country;
		return view('user.profile', ['user' => $user[0]]);
	}
	function edit() {
		//check current user id??

		$user = DB::table('users')->where('id','=', 1)->get();
		// print_r($user[0]->id);die();
		$user[0]->info = $user[0]->address1.", ".$user[0]->town_city.", ".$user[0]->county.", ".$user[0]->country;
		return view('user.edit', ['user' => $user[0]]);
	}
}