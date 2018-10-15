@extends('layouts.admin')

@section('content')



<h1 class="page-header">{{__('Tất cả sản phẩm')}}</h1>  

<div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá nhập vào</th>
                <th>Giá bán ra</th>
                <th>Size</th>
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
                <td>{{$product->buying_price}}</td>
                <td>{{$product->selling_price}}</td>
                <td>{{$product->size}}</td>
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