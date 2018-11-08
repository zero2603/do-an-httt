@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Sửa sản phẩm')}}</h1>

<div>
        <form method="POST" action={{route('products.update', $product->id)}}>
            @method('PUT')
            {{ csrf_field() }}
            <div class="form-group">
                <label>Tên sản phẩm</label>
                <input type="text" class="form-control" name="product_name" value="{{$product->product_name}}" required/>
            </div>
            <div class="form-group">
                <label>Mô tả về sản phẩm</label>
            <textarea name="description" class="form-control" id="editor1">{{$product->description}}</textarea>
            </div>
            <div class="form-group">
                <label>Giá nhập vào</label>
            <input type="number" class="form-control" name="buying_price" value="{{$product->buying_price}}" required/>
            </div>
            <div class="form-group">
                <label>Giá bán ra</label>
                <input type="number" class="form-control" name="selling_price" value="{{$product->selling_price}}" required/>
            </div>
            <div class="form-group">
                <label>Size</label>
                <input type="text" class="form-control" name="size" value="{{$product->size}}" required/>
            </div>
            <div class="form-group">
                <label>Màu sắc</label>
                <input type="text" class="form-control" name="color" value="{{$product->color}}" />
            </div>
            <div class="form-group">
                <label>Chiết khấu giảm giá</label>
                <input type="text" class="form-control" name="discount" value="{{$product->discount}}" />
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
        <form method="POST" action={{route('products.destroy', $product->id)}} id="delete-product-form" class="d-none">
            @method('DELETE')
            {{ csrf_field() }}
        </form>
</div>

{{-- ckeditor --}}
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script> CKEDITOR.replace('editor1'); </script>
<script>
    function remove() {
        document.getElementById("delete-product-form").submit();
    }
</script>
@endsection