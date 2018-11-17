@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Màu sắc')}}</h1>  
<div>
    <form method="POST" action={{route('attributes.add_color')}}>
        {{ csrf_field() }}
        <div class="form-group row">
            <div class="col-md-3">
                <input type="text" placeholder="Tên màu" name="name" class="form-control" required/>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            @foreach($colors as $color)
            <tr>
                <td>{{$color->id}}</td>
                <td>{{$color->name}}</td>
                <td>
                    <form method="POST" action={{route('attributes.remove_color', $color->id)}}>
                        @method('DELETE')
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection