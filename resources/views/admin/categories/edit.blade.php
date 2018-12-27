@extends('layouts.admin')

@section('content')

    <h1 class="page-header">{{__('Sửa thông tin danh mục')}}</h1>

    <div>
        @if (\Session::has('alert'))
            <div class="alert alert-danger">
                    {!! \Session::get('alert') !!}
            </div>
        @endif

        <form method="POST" action={{route('categories.update', $category->id)}}>
            @method('PUT')
            {{ csrf_field() }}
            <div class="form-group">
                <label>Tên danh mục</label>
                <input type="text" class="form-control" name="name" value="{{$category->name}}" required/>
            </div>
            <div class="form-group">
                <label>Danh mục cha</label>
                <select class="form-control" name="parent_id">
                    <option value="{{NULL}}" {{$category->parent_id == NULL ? 'selected' : ''}}>-- Không có --</option>
                    @foreach ($categories as $item)
                        <option value="{{$item->id}}" {{$category->parent_id == $item->id ? 'selected' : ''}}>
                            {{$item->name}}
                        </option>
                    @endforeach
                </select>
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
        <div class="d-none">
            <form method="POST" action={{route('categories.destroy', $category->id)}} id="delete-category-form">
                 @method('DELETE')
                {{ csrf_field() }}
            </form>
        </div>
</div>

<script>
    function remove() {
        if(confirm("Bạn có chắc chắn muốn xóa danh mục này?")) {
            document.getElementById("delete-category-form").submit();
        }
    }
</script>

@endsection