@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Tất cả sản phẩm')}}</h1>  

<div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Mô tả</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{$product->id}}</td>
                <td>
                    <a href="products/{{$product->id}}/edit">{{$product->product_name}}</a>
                </td>
                <td>{!!substr($product->description, 0, 200)!!}...</td>
                <td>
                    <form method="POST" action={{route('products.destroy', $product->id)}}>
                        @method('DELETE')
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
</div>


@endsection