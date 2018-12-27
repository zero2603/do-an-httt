@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Sizes')}}</h1>  
<div>
    @if (\Session::has('alert'))
        <div class="alert alert-danger">
                {!! \Session::get('alert') !!}
        </div>
    @endif
    
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
                    <button type="submit" class="btn btn-sm btn-danger" onclick="remove({{$size->id}});">
                        Xóa
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <form method="POST" class="d-none" id="delete-size-form">
        @method('DELETE')
        {{ csrf_field() }}
    </form>
</div>

<script>
    var form = document.getElementById("delete-size-form");
    function remove(id) {
        let url = `{{url('/')}}/admin/product-attribute/sizes/` + id;
        if(confirm("Bạn có chắc chắn muốn xóa mục này?")) {
            form.setAttribute('action', url);
            form.submit();
        }
    }
</script>

@endsection