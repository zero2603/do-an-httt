@extends('layouts.main')

@section('content-profile')
<style>
    .icon img{
    padding-top: 31px;
    }
    .contact-address p span{
        width: 220px !important;
    }
    .contact-area .contact-info .contact-address p {
        font-size: 14px !important;
        font-weight: 600;
        margin-bottom: 20px !important;
    }
    .cangiua{
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>
	<div class="contact-area d-flex align-items-center">

        
        <div style="width: 30%">
            <img src="{{url('/').'/'.$user->avatar}}" width="200px" height="100%" class="cangiua">
        </div>
        

        <div class="contact-info">
            <p style="font-size: 30px!important;">THÔNG TIN CÁ NHÂN</p>
            <h3><span>{{$user->first_name}} </span><span> {{$user->last_name}}</span></h3>
            <!-- <p>Des.</p> -->

            <div class="contact-address mt-50">
                <p><span>Địa chỉ:</span>{{$user->info}}</p>
                <p><span>Số điện thoại:</span>{{$user->phone_number}}</p>
                <p><span>Tài khoản (email):</span>{{$user->email}}</p>
                <div class="text-center">
                    <a href="/user/profile/edit"><button  style="border-radius: 30px; border: none; padding: 20px">Chỉnh sửa thông tin</button></a>
                </div>
            </div>

        </div>

    </div>