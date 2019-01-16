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
        <div class="row">
            <div class="col-sm-2">
                <select class="form-control" onchange="query(this);" name="category_id">
                    <option value="">Danh mục</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}" class="categories">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                <select class="form-control" onchange="query(this);" name="color_id">
                    <option value="">Màu sắc</option>
                    @foreach($colors as $color)
                    <option value="{{$color->id}}" class="colors">{{$color->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                <select class="form-control" onchange="query(this);" name="size_id">
                    <option value="">Size</option>    
                    @foreach($sizes as $size)
                    <option value="{{$size->id}}" class="sizes">{{$size->name}}</option>
                    @endforeach      
                </select>
            </div>
            <div class="col-sm-4">
                <input type="text" name="name" class="form-control" id="name" placeholder="Tìm theo tên...." onchange="searchName(this);"/>
            </div>
        </div>
    
<hr/>
</div>
<div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th width="10%">Ảnh</th>
                <th width="10%">Tên sản phẩm</th>
                <th width="10%">Danh mục</th>
                <th width="40%">Mô tả</th>
                <th width="15%">Giá</th>
                <th width="15%">Option</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{$product->id}}</td>
                <td width="10%">
                    <img src="/{{$product->source}}" class="list-product-images"/>
                </td>
                <td>
                    <a href="{{url('admin/products/'.$product->id.'/edit')}}">{{$product->product_name}}</a>
                </td>
                <td>{{$product->category_name}}</td>
                <td>{!!substr($product->description, 0, 200)!!}...</td>
                <td><b>{{$product->selling_price}} VND</b></td>
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
<script>
    var timer = 0;
    var url = new URL(window.location.href);
    var urlParams = new URLSearchParams(url.search.slice(1));

    var categories = document.getElementsByClassName("categories");
    for(let element of categories) {
        if(element.value.toString() === urlParams.get('category_id')) {
            element.setAttribute('selected', true);
        }
    }

    var colors = document.getElementsByClassName("colors");
    for(let element of colors) {
        if(element.value.toString() === urlParams.get('color_id')) {
            element.setAttribute('selected', true);
        }
    }

    var sizes = document.getElementsByClassName("sizes");
    for(let element of sizes) {
        if(element.value.toString() === urlParams.get('size_id')) {
            element.setAttribute('selected', true);
        }
    }

    document.getElementById("name").value = urlParams.get('name');

    function query(item) {
        if(item.value) {
            urlParams.set(item.name, item.value);
        } else {
            urlParams.delete(item.name, item.value);
        }
        
        window.location.href = window.location.origin + '/admin/products?' + urlParams.toString();
    }

    function searchName(item) {
        clearTimeout(timer);
        timer = setTimeout(function() {
            query(item);
        }, 1000);
    }

</script>

@endsection