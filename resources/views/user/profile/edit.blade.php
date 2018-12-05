@extends('layouts.main')

@section('content-profile')
	<div>
        <div align="center">
             <span><h2>Edit Profile</h2></span>
        </div>
       <form action="/user/profile" method="POST">
            <div align="center">
            <div>
                First Name: <input type="text" name="first_name" value="{{$user->first_name}}" required>
            </div><br>
            <div>
                Last name: <input type="text" name="last_name" value="{{$user->last_name}}" required>
            </div><br>
            <div>
                Photo: <input type="file" name="photo" value="{{$user->photo}}">
            </div><br>
            <div>
                Email: <input type="email" name="email" value="{{$user->email}}" required>
            </div><br>
            <div>
                Password: <input id="password" type="password" name="password" value="{{$user->password}}" required>
            </div><br>
            <div>
                Confirm Password: <input id="confirmPassword" type="password" name="password" value="{{$user->password}}" required>
            </div><br>
            <div>
                Phone: <input id="phone" type="number" name="phone_number" value="{{$user->phone_number}}" required>
            </div><br>
            <div align="center" style="margin-left: 50%">
               
                <select>
                    <option>Male</option>
                    <option>Female</option>
                </select><br>
            </div><br>
            <div>
                Address: <input type="text" name="address1" value="{{$user->address1}}" required>
            </div><br>
            <div>
                Town City: <input type="text" name="town_city" value="{{$user->town_city}}" required>
            </div><br>
            <div>
                County: <input type="text" name="county" value="{{$user->county}}" required>
            </div><br>
            <div>
                Country: <input type="text" name="country" value="{{$user->country}}" required>
            </div><br>
            <div align="center">
                <button type="submit"  id="submit" name="submit" style="border-radius: 30px; border: none; padding: 20px">Save Profile</button>
            </div><br>
        </div>
       </form>   
    </div>
<script>
    var password = window.document.getElementById('password').value;
    var confirmPassword = window.document.getElementById('confirmPassword').value;
    if (password != confirmPassword) {
        window.document.getElementById('submit').disabled = true;
    } else {
        window.document.getElementById('submit').disabled = false;
    }
</script>