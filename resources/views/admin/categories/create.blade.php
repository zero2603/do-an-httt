@extends('layouts.admin')

@section('content')

    <h1 class="page-header">{{__('Thêm mới danh mục')}}</h1>

    <div>
        <form method="POST" action={{route('categories.store')}}>
            {{ csrf_field() }}
            <div class="form-group">
                <label>Tên danh mục</label>
                <input type="text" class="form-control" name="name" required/>
            </div>
            <div class="form-group">
                <label>Danh mục cha</label>
                <select class="form-control" name="parent_id">
                    <option value={{NULL}}>-- Không có --</option>
                    @foreach ($categories as $category)
                        <option value={{$category->id}}>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group row">
                <div class="col-sm-1">
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
                <div class="col-sm-1">
                    <button type="reset" class="btn btn-outline-primary">Hủy</button>
                </div>
            </div>    
        </form>
</div>

@endsection