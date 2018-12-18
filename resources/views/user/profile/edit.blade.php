@extends('layouts.main')

@section('content-profile')
	<div class="container mt-4 mb-4">
        <div class="text-center">
             <span><h2>Edit Profile</h2></span>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <form action="{{url('/user/profile/update')}}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-6">
                                <div class="row">
                                    <label class="col-4">Họ:</label>
                                    <input class="form-control col-8" type="text" name="data[first_name]" value="{{$user->first_name}}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <label class="col-4">Tên:</label>
                                    <input class="form-control col-8" type="text" name="data[last_name]" value="{{$user->last_name}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Email:</label>
                            <input class="form-control col-8" type="email" name="data[email]" value="{{$user->email}}" required>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Số điện thoại:</label>
                            <input class="form-control col-8" id="phone" type="number" name="data[phone_number]" value="{{$user->phone_number}}" required>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Giới tính:</label>
                            <select class="custom-select col-8" required name="data[gender]">
                                <option value="M" selected="{{$user->gender == "M"}}">Nam</option>
                                <option value="F" selected="{{$user->gender == "F"}}">Nữ</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Địa chỉ 1:</label>
                            <input class="form-control col-8" type="text" name="data[address1]" value="{{$user->address1}}">
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Địa chỉ 2:</label>
                            <input class="form-control col-8" type="text" name="data[address2]" value="{{$user->address2}}">
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Xã/Phường/Thị trấn:</label>
                            <input class="form-control col-8" type="text" name="data[town_city]" value="{{$user->town_city}}">
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Quận/Huyện:</label>
                            <input class="form-control col-8" type="text" name="data[county]" value="{{$user->county}}">
                        </div>
                        <div class="form-group row"> 
                            <label class="col-4">Quốc gia:</label>
                            <input class="form-control col-8" type="text" name="data[country]" value="{{$user->country}}">
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
                            <form method="POST" action="{{url('/user/profile/update-avatar')}}" id="change-avatar-form">
                                @csrf
                                <label id="change-avatar-btn">
                                    Đổi avatar
                                    <input type="file" class="d-none" name="avatar" onchange="submitAvatar();" accept="image/*"/>
                                </label>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    @if (\Session::has('alert'))
                        <div class="alert alert-danger">
                                {!! \Session::get('alert') !!}
                        </div>
                    @endif
                    <form method="POST" action="{{url('/user/profile/update-password')}}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-4">Nhập lại mật khẩu hiện tại:</label>
                            <input class="form-control col-8" type="password" name="data[password]" required>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Nhập mật khẩu mới:</label>
                            <input class="form-control col-8" type="password" name="data[new_password]" required>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Xác nhận mật khẩu mới:</label>
                            <input class="form-control col-8" type="password" name="data[confirm_new_password]" required>
                        </div>
                        <button id="change-password-btn" type="submit">
                            <i class="fa fa-lock"></i> Đổi mật khẩu
                        </button>
                    </form>
                </div>    
            </div>
        </div>  
    </div>
    <script>
        var form = document.getElementById("change-avatar-form");
        function submitAvatar() {
            form.submit();
        }
    </script>
@endsection