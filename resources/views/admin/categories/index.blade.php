@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Tất cả danh mục sản phẩm')}}</h1>  
<a href="{{url('admin/categories/create')}}">
    <button class="btn btn-success">
        <i class="fa fa-plus"></i> Thêm danh mục sản phẩm
    </button>
</a>
<hr/>

<div>
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
                            <form method="POST" action={{route('categories.destroy', $category->id)}}>
                                @method('DELETE')
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->links() }}
</div>


@endsection
