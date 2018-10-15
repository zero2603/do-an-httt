@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Thêm sản phẩm')}}</h1>

<div>
        <form method="POST" action={{route('products.store')}}>
            {{ csrf_field() }}
            <div class="form-group">
                <label>Tên sản phẩm</label>
                <input type="text" class="form-control" name="product_name" required/>
            </div>
            <div class="form-group">
                <label>Mô tả về sản phẩm</label>
                <textarea name="description" class="form-control " id="editor1"></textarea>
            </div>
            <div class="form-group">
                <label>Giá nhập vào</label>
                <input type="number" class="form-control" name="buying_price" required/>
            </div>
            <div class="form-group">
                <label>Giá bán ra</label>
                <input type="number" class="form-control" name="selling_price" required/>
            </div>
            <div class="form-group">
                <label>Size</label>
                <input type="text" class="form-control" name="size" required/>
            </div>
            <div class="form-group">
                <label>Màu sắc</label>
                <input type="text" class="form-control" name="color" />
            </div>
            <div class="form-group">
                <label>Chiết khấu giảm giá</label>
                <input type="text" class="form-control" name="discount" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                <button type="reset" class="btn btn-outline-primary">Hủy</button>
            </div>
        </form>
</div>

{{-- ckeditor --}}
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script> CKEDITOR.replace('editor1'); </script>
@endsection