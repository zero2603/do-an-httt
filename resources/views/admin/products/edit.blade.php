@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Sửa sản phẩm')}}</h1>

<div>
        <form method="POST" action={{route('products.update', $product->id)}}>
            @method('PUT')
            {{ csrf_field() }}
            <div class="form-group">
                <label>Tên sản phẩm</label>
                <input type="text" class="form-control" name="product[product_name]" value="{{$product->product_name}}" required/>
            </div>
            <div class="form-group">
                <label>Mô tả về sản phẩm</label>
            <textarea name="product[description]" class="form-control" id="editor1">{{$product->description}}</textarea>
            </div>
            <div class="form-group">
                <label>Chiết khấu giảm giá</label>
                <input type="text" class="form-control" name="product[discount]" value="{{$product->discount}}" />
            </div>

            <div class="form-group">
                <h4>Chọn danh mục</h4>
                <div class="row">
                    @foreach ($categories as $category)
                        <div class="col-md-2">
                            <input type="checkbox" name="categories[]" value="{{$category->id}}" {{in_array($category->id, $product->categories) ? 'checked' : ''}}/>
                            {{$category->name}}
                        </div>
                    @endforeach
                </div>
            </div>
            <hr/>

            <div>
                <div class="float-left">
                    <h4>Biến thể</h4>
                </div>
                <div class="float-right">
                    <button type="button" class="btn btn-secondary" onclick="addAttr()">
                        Thêm biến thể
                    </button>
                </div>
            </div>
            <div class="form-group" id="attribute_list">
            
            @foreach ($product->attributes as $item)
                <div class="row attribute_input_group">
                    <div class="col-md-2">
                        <label>Size</label>
                        <select class="form-control" name="attr[]" required>
                        @foreach ($sizes as $size)
                            <option value="{{$size->id}}" {{$item->size_id == $size->id ? 'selected' : ''}}>{{$size->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Màu sắc</label>
                        <select class="form-control" name="attr[]" required>
                            @foreach ($colors as $color)
                                <option value="{{$color->id}}" {{$item->color_id == $color->id ? 'selected' : ''}}>{{$color->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Giá nhập vào</label>
                        <input type="number" class="form-control" name="attr[]" value={{$item->buying_price}} required/>
                    </div>
                    <div class="col-md-3">
                        <label>Giá bán ra</label>
                        <input type="number" class="form-control" name="attr[]" value={{$item->selling_price}} required/>
                    </div>  
                    <div class="col-md-1">
                        <label></label>
                        <div>
                            <button class="remove-attr-btn" type="button" onclick="removeAttr()">
                                <i class="fa fa-times fa-2x"></i>
                            </button>
                        </div>
                    </div> 
                </div>          
            @endforeach
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

        <div class="row attribute_input_group d-none" id="attr_item">
            <div class="col-md-2">
                <label>Size</label>
                <select class="form-control" name="attr[]" required>
                @foreach ($sizes as $size)  
                    <option value="{{$size->id}}">{{$size->name}}</option>
                @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Màu sắc</label>
                <select class="form-control" name="attr[]" required>
                    @foreach ($colors as $color)
                        <option value="{{$color->id}}">{{$color->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Giá nhập vào</label>
                <input type="number" class="form-control" name="attr[]" required/>
            </div>
            <div class="col-md-3">
                <label>Giá bán ra</label>
                <input type="number" class="form-control" name="attr[]" required/>
            </div>  
            <div class="col-md-1">
                <label></label>
                <div>
                    <button class="remove-attr-btn" type="button" onclick="removeAttr()">
                        <i class="fa fa-times fa-2x"></i>
                    </button>
                </div>
            </div> 
        </div>
</div>

{{-- ckeditor --}}
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script> CKEDITOR.replace('editor1'); </script>
<script>
    function remove() {
        document.getElementById("delete-product-form").submit();
    }
</script>
    <script>
        var attrList = document.getElementById('attribute_list');
        var attrInputGroup = document.getElementById('attr_item');
        var i = 0;
        
        function addAttr() {    
            var temp = attrInputGroup.cloneNode(true);
            temp.classList.remove('d-none');
            attrList.appendChild(temp);
        }
    
        function removeAttr() {
            if(attrList.childElementCount > 1) {
                var current_id = event.target.parentNode.parentNode.parentNode.parentNode.id;
                attrList.removeChild(document.getElementById(current_id));
            } else {
                alert("Phải có ít nhất một biến thể!");
            }
        }
    </script>
@endsection