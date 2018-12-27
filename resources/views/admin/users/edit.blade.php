@extends('layouts.admin')

@section('content')

    <h1 class="page-header">{{__('Sửa thông tin người dùng')}}</h1>

    <div>
        <form method="POST" action={{route('users.update', $user->id)}}>
            @method('PUT')
            {{ csrf_field() }}
            <div class="form-group row">
                <div class="col-md-3">
                    <label>Họ</label>
                    <input type="text" class="form-control" name="first_name" value="{{$user->first_name}}" required/>
                </div>
                <div class="col-md-3">
                    <label>Tên</label>
                    <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}" required/>
                </div>
                <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{$user->email}}" readonly/>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label>Số điện thoại</label>
                    <input type="number" class="form-control" name="phone_number" value="{{$user->phone_number}}" required/>
                </div>
                <div class="col-md-6">
                    <label>Giới tính</label>
                    <select class="form-control" name="gender" required>
                        <option value="M" {{$user->gender=='M' ? 'selected' : ''}}>Nam</option>
                        <option value="F" {{$user->gender=='F' ? 'selected' : ''}}>Nữ</option>
                    </select>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-md-6">
                    <label>Xã/Phường</label>
                    <input type="text" class="form-control" name="town_city" value="{{$user->town_city}}"/>
                </div>
                <div class="col-md-6">
                    <label>Quận</label>
                    <input type="text" class="form-control" name="county" value="{{$user->county}}"/>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label>Địa chỉ 1</label>
                    <input type="text" class="form-control" name="address1" value="{{$user->address1}}"/>
                </div>
                <div class="col-md-6">
                    <label>Địa chỉ 2</label>
                    <input type="text" class="form-control" name="address2" value="{{$user->address2}}"/>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-1">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
                <div class="col-sm-1">
                    <button type="button" class="btn btn-danger" onclick="remove()">Xóa</button>
                </div>
            </div>    
        </form>
        <form method="POST" action={{route('users.destroy', $user->id)}} id="delete-user-form" class="d-none">
            @method('DELETE')
            {{ csrf_field() }}
        </form>
</div>

<script>
    function remove() {
        if(confirm("Bạn có chắc chắn muốn xóa?")) {
            document.getElementById("delete-user-form").submit();
        }
    }
</script>
@endsection