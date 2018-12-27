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
                            <button type="button" class="btn btn-sm btn-danger" onclick="remove({{$product->id}});">
                                Xóa
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form method="POST" class="d-none" id="delete-product-form">
        @method('DELETE')
        {{ csrf_field() }} 
    </form>

    {{ $products->links() }}
</div>

<script>
    var form = document.getElementById("delete-product-form");
    function remove(id) {
        let url = `{{url('/')}}/admin/products/` + id;
        if(confirm("Bạn có chắc chắn muốn xóa?")) {
            form.setAttribute('action', url);
            form.submit();
        }
    }
</script>

@endsection