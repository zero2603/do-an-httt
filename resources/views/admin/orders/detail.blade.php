@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Chi tiết đơn hàng')}}</h1>

<div>
    <div class="row">
        <div class="col-md-6">
            <h3>Thông tin đơn hàng</h3>
            <form method="POST" action="{{url('/admin/orders/'.$order->id)}}">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <div class="col-md-4"><b>Trạng thái:</b></div>
                    <div class="col-md-5">
                        <select class="form-control" name="status">
                            <option value="cancelled" {{$order->status == "cancelled" ? "selected" : ""}}>Đã hủy</option>
                            <option value="finished" {{$order->status == "finished" ? "selected" : ""}}>Hoàn thành</option>
                            <option value="pending" {{$order->status == "pending" ? "selected" : ""}}>Đang chờ xử lý</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
            <div class="form-group row">
                <div class="col-md-4"><b>Ngày tạo:</b></div>
                <div class="col-md-8">{{$order->created_at}}</div>
            </div>
            <div class="form-group row">
                <div class="col-md-4"><b>Ngày cập nhật:</b></div>
                <div class="col-md-8">{{$order->updated_at}}</div>
            </div>
            <div class="form-group row">
                <div class="col-md-4"><b>Người tạo:</b></div>
                <div class="col-md-8">
                    <a href="{{url('/admin/users/'.$order->user_id.'/edit')}}">
                        {{$order->creator_first_name}} {{$order->creator_last_name}}
                    </a>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4"><b>Email người tạo:</b></div>
                <div class="col-md-8">{{$order->creator_email}}</div>
            </div>
            <hr/>
            <h3>Thông tin giao hàng</h3>
            <div class="form-group row">
                <div class="col-md-4"><b>Tên người nhận:</b></div>
                <div class="col-md-8">{{$order->receiver_name}}</div>
            </div>
            <div class="form-group row">
                <div class="col-md-4"><b>SĐT người nhận:</b></div>
                <div class="col-md-8">{{$order->receiver_phone}}</div>
            </div>
            <div class="form-group row">
                <div class="col-md-4"><b>Địa chỉ giao hàng:</b></div>
                <div class="col-md-8">{{$order->shipment_address}}</div>
            </div>
            <hr/>
            <h3>Thông tin thanh toán</h3>
            <div class="form-group row">
                <div class="col-md-4"><b>Phương thức thanh toán:</b></div>
                <div class="col-md-8">{{$order->payment_type}}</div>
            </div>
            <div class="form-group row">
                <div class="col-md-4"><b>Thông tin thêm:</b></div>
                <div class="col-md-8">{{$order->other_payment_info}}</div>
            </div>
            <div class="form-group">
                <form method="POST" action={{url('/admin/orders/'.$order->id)}}>
                    @method('DELETE')
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-sm btn-danger">Xóa đơn hàng</button>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <h3>Danh sách sản phẩm</h3>
            <hr/>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Item size</th>
                        <th>Item color</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order_items as $item)
                        <tr>
                            <td>{{$item->product_id}}</td>
                            <td>{{$item->order_item_size}}</td>
                            <td>{{$item->order_item_color}}</td>
                            <td>{{$item->order_item_quantity}}</td>
                            <td>{{$item->order_item_price}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4">
                            <b>Tổng cộng</b>
                        </td>
                        <td>{{$order->total_amount}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection