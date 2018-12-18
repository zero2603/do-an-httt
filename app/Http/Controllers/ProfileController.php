<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Users;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

	function update(Request $request) {
		$user = Auth::user();
		$data = $request->get('data');

		foreach($data as $key => $value) {
			$user->$key = $value;
		}
		$user->save();
		return redirect('/user/profile');
	}

	function updateAvatar(Request $request) {
		$user = Auth::user();
		$image = $request->avatar;
		$file = Storage::disk('local')->put('/public/images', $image);

		$user->avatar = 'storage/images/'.baseName($file);
		$user->save();
		return redirect('/user/profile');
	}

	function updatePassword(Request $request) {
		$user = Auth::user();
		$data = $request->get('data');
		if(Hash::check($data['password'], $user->password)) {
			if($data['new_password'] == $data['confirm_new_password']) {
				$user->password = Hash::make($data['new_password']);
				$user->save();
			
				return redirect('/user/profile');
			} else {
				return redirect()->back()->with(['alert' => 'Xác nhận mật khẩu mới không khớp']);
			}
		} else {
			return redirect()->back()->with(['alert' => 'Bạn đã nhập mật khẩu cũ sai']);
		}
	}
}