@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Tất cả sản phẩm')}}</h1>  
<a href="{{url('admin/products/create')}}">
    <button class="btn btn-success">
        <i class="fa fa-plus"></i> Thêm sản phẩm
    </button>
</a>
<hr/>
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
                    <a href="{{url('admin/products/'.$product->id.'/edit')}}">{{$product->product_name}}</a>
                </td>
                <td>{!!substr($product->description, 0, 200)!!}...</td>
                <td>
                    <div class="row">
                        <div class="col-md-6">
                        <a href="{{url('admin/products/'.$product->id.'/edit')}}">
                                <button type="button" class="btn btn-sm btn-primary">Sửa</button>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <form method="POST" action={{route('products.destroy', $product->id)}}>
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
    {{ $products->links() }}
</div>


@endsection