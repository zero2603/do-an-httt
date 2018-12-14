@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Sửa sản phẩm')}}</h1>

<div>
    <div>
        Sản phẩm này có {{$number_of_comments}} bình luận. <a href="javascript:void(0);" onclick="viewComments();">Xem bình luận</a>
    </div>
        <h4>Hình ảnh sản phẩm</h4>
        <div class="row" id="list-images">
        @foreach ($product->images as $item)
            <div class="col-md-3 product-images">
                <img src="{{url('').'/'.$item->source}}"/>
                <i class="fa fa-times fa-3x remove-image-button" id={{$item->id}}></i>
            </div>
        @endforeach
            <div class="col-md-3 product-images">
                <form id="form-add-image" action="{{url('/admin/product/images/upload')}}" method="post" enctype="multipart/form-data" onsubmit="return false">
                    {{ csrf_field() }}
                    <label id="add-image-button">
                        <i class="fa fa-plus fa-4x"></i>
                        <input type="file" class="d-none" id="input-add-image" name="images[]" multiple/>
                    </label>
                    <input type="text" class="d-none" name="product_id" value="{{$product->id}}" />
                </form>
            </div>
        </div>
        <hr/>
        <h4>Chi tiết sản phẩm</h4>
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

        <div class="comment-area">
            <button type="button" class="btn btn-info d-none" id="open-modal-btn" data-toggle="modal" data-target="#myModal">Open Modal</button>
            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Tất cả bình luận</h4>
                        </div>
                        <div class="modal-body">
                            @foreach ($comments as $comment)
                                <div class="row comment">
                                    <div class="col-md-2">
                                        <img src="{{url('/')."/".$comment->user_avatar}}" class="comment_user_avatar"/>
                                    </div>
                                    <div class="col-md-9">
                                        <div><b>{{$comment->user_first_name}} {{$comment->user_last_name}}</b></div>
                                        <div>{{$comment->rating}} <i class="fa fa-star"></i>   {{$comment->created_at}}</div> 
                                        <div>{{$comment->content}}</div>
                                        {{-- reply --}}
                                        <div class="reply">
                                            @foreach ($comment->reply as $item)
                                                <div class="row comment">
                                                    <div class="col-md-2">
                                                        <img src="{{url('/')."/".$item->user_avatar}}" class="comment_user_avatar"/>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div><b>{{$item->user_first_name}} {{$item->user_last_name}}</b></div>
                                                        <div>{{$item->rating}} <i class="fa fa-star"></i>   {{$item->created_at}}</div> 
                                                        <div>{{$item->content}}</div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <form method="POST" action="{{url('/admin/comment')}}/{{$item->id}}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button class="btn-delete-comment" type="submit"  onclick="return confirm('Are you sure?')">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <form method="POST" action="{{url('/admin/comment')}}/{{$comment->id}}">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn-delete-comment" type="submit">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
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

        document.getElementById('form-add-image').submit(function(e) {
            e.preventDefault();
            console.log('aaaaaaaaaaa');
        })
    });

    function viewComments() {
        document.getElementById('open-modal-btn').click();
    }
</script>
@endsection