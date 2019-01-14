@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Tất cả người dùng')}}</h1>  

<div>
    <div class="row">
        <div class="col-sm-3">
            <input type="text" class="form-control" name="name" id="name" onchange="searchName(this);" placeholder="Tìm theo tên..."/>
        </div>
    </div>
    <hr/>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Số ĐT</th>
                <th>Email</th>
                <th>Giới tính</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>
                <a href="users/{{$user->id}}/edit">{{$user->first_name}} {{$user->last_name}}</a>
                </td>
                <td>{{$user->phone_number}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->gender}}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="remove({{$user->id}});">
                        Xóa
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <form method="POST" id="delete-user-form" class="d-none">
        @method('DELETE')
        {{ csrf_field() }}
    </form>

    {{ $users->links() }}
</div>

<script>
    var form = document.getElementById("delete-user-form");
    function remove(id) {
        let url = `{{url('/')}}/admin/users/` + id;
        if(confirm("Bạn có chắc chắn muốn xóa?")) {
            form.setAttribute('action', url);
            form.submit();
        }
    }
</script>
<script>
    var timer = 0;
    var url = new URL(window.location.href);
    var urlParams = new URLSearchParams(url.search.slice(1));

    document.getElementById("name").value = urlParams.get('name');

    function searchName(item) {
        clearTimeout(timer);
        timer = setTimeout(function() {
            if(item.value) {
                urlParams.set(item.name, item.value);
            } else {
                urlParams.delete(item.name, item.value);
            }
            window.location.href = window.location.origin + '/admin/users?' + urlParams.toString();
        }, 1000);
    }
</script>

@endsection