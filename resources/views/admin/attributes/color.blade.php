@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Màu sắc')}}</h1>  
<div>
    @if (\Session::has('alert'))
        <div class="alert alert-danger">
                {!! \Session::get('alert') !!}
        </div>
    @endif

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
                    <button type="submit" class="btn btn-sm btn-danger" onclick="remove({{$color->id}});">
                        Xóa
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <form method="POST" class="d-none" id="delete-color-form">
        @method('DELETE')
        {{ csrf_field() }}
    </form>
</div>

<script>
    var form = document.getElementById("delete-color-form");
    function remove(id) {
        let url = `{{url('/')}}/admin/product-attribute/colors/` + id;
        if(confirm("Bạn có chắc chắn muốn xóa mục này?")) {
            form.setAttribute('action', url);
            form.submit();
        }
    }
</script>

@endsection