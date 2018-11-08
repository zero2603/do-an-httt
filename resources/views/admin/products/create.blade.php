@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Thêm sản phẩm')}}</h1>

<div>
        <form method="POST" action={{route('products.store')}}>
            {{ csrf_field() }}
            <div class="form-group">
                <label>Tên sản phẩm</label>
                <input type="text" class="form-control" name="product[product_name]" required/>
            </div>
            <div class="form-group">
                <label>Mô tả về sản phẩm</label>
                <textarea name="product[description]" class="form-control " id="editor1"></textarea>
            </div>
            <div class="form-group">
                <label>Chiết khấu giảm giá</label>
                <input type="text" class="form-control" name="product[discount]" />
            </div>
            
            <div class="form-group">
                <h4>Chọn danh mục</h4>
                <div class="row">
                    @foreach ($categories as $category)
                        <div class="col-md-2">
                            <input type="checkbox" name="categories[]" value="{{$category->id}}"/>
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
                <div class="row attribute_input_group" id="attribute_input_group_0">
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
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                <button type="reset" class="btn btn-outline-primary">Hủy</button>
            </div>
        </form>
</div>

{{-- ckeditor --}}
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script> CKEDITOR.replace('editor1'); </script>
<script>
    var attrList = document.getElementById('attribute_list');
    var attrInputGroup = document.getElementById('attribute_input_group_0');
    var i = 0;
    
    function addAttr() {    
        var temp = attrInputGroup.cloneNode(true);
        temp.id = `attribute_input_group_${++i}`;
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