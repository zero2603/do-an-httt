@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Tất cả người dùng')}}</h1>  

<div>
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
                    <form method="POST" action={{route('users.destroy', $user->id)}}>
                        @method('DELETE')
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>


@endsection