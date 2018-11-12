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

            <hr/>
            <h4>Hình ảnh sản phẩm</h4>
            <div class="row">
            @foreach ($product->images as $item)
                <div class="col-md-3 product-images">
                    <img src="{{url('').'/'.$item->source}}"/>
                    <i class="fa fa-times fa-3x remove-image-button" id={{$item->id}}></i>
                </div>
            @endforeach
                <div class="col-md-3 product-images">
                    <label id="add-image-button">
                        <i class="fa fa-plus fa-4x"></i>
                        <input type="file" class="d-none" id="input-add-image"/>
                    </label>
                </div>
            </div>
            <hr/>

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
<script>
    $('.remove-image-button').on('click', function(e){
        e.preventDefault();
        let id = $(this).attr('id');
        let parent = $(this).parent();
        let result = confirm("Bạn chắc chắn muốn xóa ảnh này chứ?")
        if(result){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type : 'DELETE',
                url : `/admin/product/images/remove/${id}`,
                success : function(response){
                    if(response){
                        parent.remove();
                    }
                }.bind(this)
            }) 
        }
    });

    $('#add-image-button').on('change', function(e){
        e.preventDefault();
        let parent = $(this).parent();

        var form_data = new FormData();
        form_data.append('images', $('#input-add-image').prop('files'));

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'POST',
            contentType : false,
            processData : false,
            cache       : false,
            url : `/admin/product/images/upload`,
            data: form_data,

            success : function(response){
                if(response){
                    console.log(response);
                }
            }.bind(this)
        })
    });
</script>
@endsection