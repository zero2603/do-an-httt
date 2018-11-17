@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Sizes')}}</h1>  
<div>
    <form method="POST" action={{route('attributes.add_size')}}>
        {{ csrf_field() }}
        <div class="form-group row">
            <div class="col-md-3">
                <input type="text" placeholder="Tên size" name="name" class="form-control" required/>
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
            @foreach($sizes as $size)
            <tr>
                <td>{{$size->id}}</td>
                <td>{{$size->name}}</td>
                <td>
                    <form method="POST" action={{route('attributes.remove_size', $size->id)}}>
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