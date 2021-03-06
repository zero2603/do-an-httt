@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Tất cả danh mục sản phẩm')}}</h1>  
<a href="{{url('admin/categories/create')}}">
    <button class="btn btn-success">
        <i class="fa fa-plus"></i> Thêm danh mục sản phẩm
    </button>
</a>
<hr/>
<div class="row">
    <div class="col-sm-3">
        <input type="text" class="form-control" name="name" id="name" onchange="searchName(this);" placeholder="Tìm theo tên..."/>
    </div>
</div>

<div>
    @if (\Session::has('alert'))
        <div class="alert alert-danger">
                {!! \Session::get('alert') !!}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Danh mục cha</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>
                    <a href="{{url('admin/categories/'.$category->id.'/edit')}}">{{$category->name}}</a>
                </td>
                <td>
                    <a href="{{url('admin/categories/'.$category->parent_id.'/edit')}}">
                        {{$category->parent_id}}
                    </a>
                </td>
                <td width="15%">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{url('admin/categories/'.$category->id.'/edit')}}">
                                <button type="button" class="btn btn-sm btn-primary">Sửa</button>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="remove({{$category->id}});">
                                Xóa
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form method="POST" class="d-none" id="delete-category-form">
        @method('DELETE')
        {{ csrf_field() }}
    </form>

    {{ $categories->links() }}
</div>

<script>
    var form = document.getElementById("delete-category-form");
    function remove(id) {
        let url = `{{url('/')}}/admin/categories/` + id;
        if(confirm("Bạn có chắc chắn muốn xóa danh mục này?")) {
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
            window.location.href = window.location.origin + '/admin/categories?' + urlParams.toString();
        }, 1000);
    }
</script>

@endsection
