@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Tất cả danh mục sản phẩm')}}</h1>  

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
                    <a href="categories/{{$category->id}}/edit">{{$category->name}}</a>
                </td>
                <td>
                    <a href="categories/{{$category->parent_id}}/edit">
                        {{$category->parent_id}}
                    </a>
                </td>
                <td>
                    <form method="POST" action={{route('categories.destroy', $category->id)}}>
                        @method('DELETE')
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->links() }}
</div>


@endsection
