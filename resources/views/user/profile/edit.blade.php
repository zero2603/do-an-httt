@extends('layouts.main')

@section('content-profile')
	<div class="container mt-4 mb-4">
        <div class="text-center">
             <span><h2>Edit Profile</h2></span>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <form action="/user/profile" method="POST">
                        <div class="form-group row">
                            <div class="col-6">
                                <div class="row">
                                    <label class="col-4">Họ:</label>
                                    <input class="form-control col-8" type="text" name="first_name" value="{{$user->first_name}}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <label class="col-4">Tên:</label>
                                    <input class="form-control col-8" type="text" name="last_name" value="{{$user->last_name}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Email:</label>
                            <input class="form-control col-8" type="email" name="email" value="{{$user->email}}" required>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Số điện thoại:</label>
                            <input class="form-control col-8" id="phone" type="number" name="phone_number" value="{{$user->phone_number}}" required>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Giới tính:</label>
                            <select class="custom-select col-8">
                                <option value="M" selected="{{$user->gender == "M"}}">Nam</option>
                                <option value="F" selected="{{$user->gender == "F"}}">Nữ</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Địa chỉ 1:</label>
                            <input class="form-control col-8" type="text" name="address1" value="{{$user->address1}}" required>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Địa chỉ 2:</label>
                            <input class="form-control col-8" type="text" name="address2" value="{{$user->address2}}" required>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Xã/Phường/Thị trấn:</label>
                            <input class="form-control col-8" type="text" name="town_city" value="{{$user->town_city}}" required>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Quận/Huyện:</label>
                            <input class="form-control col-8" type="text" name="county" value="{{$user->county}}" required>
                        </div>
                        <div class="form-group row"> 
                            <label class="col-4">Quốc gia:</label>
                            <input class="form-control col-8" type="text" name="country" value="{{$user->country}}" required>
                        </div>
                        <div class="text-center">
                            <button type="submit"  id="submit" name="submit" style="border-radius: 30px; border: none; padding: 20px">Save Profile</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="row">
                        <div class="col-6">
                            <img src="{{url('/').'/'.$user->avatar}}"/>
                        </div>
                        <div class="col-6">
                            <label id="change-avatar-btn">
                                Đổi avatar
                                <input type="file" class="d-none" name="avatar" />
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <button id="change-password-btn">
                        <i class="fa fa-lock"></i> Đổi mật khẩu
                    </button>
                </div>    
            </div>
        </div>  
    </div>
@endsection