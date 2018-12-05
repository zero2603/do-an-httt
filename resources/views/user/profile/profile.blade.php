@extends('layouts.main')

@section('content-profile')
	<div class="contact-area d-flex align-items-center">

        
        <div style="width: 30%">
        	<img src="../assets/img/anonymous.jpg" width="100%" height="100%">
        </div>
        

        <div class="contact-info">
            <h2><span>{{$user->first_name}} </span><span> {{$user->last_name}}</span></h2>
            <!-- <p>Des.</p> -->

            <div class="contact-address mt-50">
                <p><span>address:</span>{{$user->info}}</p>
                <p><span>telephone:</span>{{$user->phone_number}}</p>
                <p><span>Account(email):</span>{{$user->email}}</p>
                <p><span>Password:</span>{{$user->password}}</p>
                <div align="center">
                    <a href="/user/profile/edit"><button  style="border-radius: 30px; border: none; padding: 20px">Edit Profile</button></a>
                </div>
            </div>

        </div>

    </div>