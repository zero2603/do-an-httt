@extends('layouts.main')

@section('content')

<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img">
    <div class="container h-100" >
        <div class="row h-100 align-items-center" >
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>CHI TIẾT ĐƠN HÀNG</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Breadcumb Area End ##### -->

<div class="container mb-4">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Mã số đơn hàng: #{{$order->id}} - {{$order->status}}
                    </h5>
                    <h5 class="card-title">Thông tin giao hàng</h5>
                    <div class="row">
                        <div class="col-4">Người nhận hàng</div>
                        <div class="col-8">{{$order->receiver_name}}</div>
                    </div>
                    <div class="row">
                        <div class="col-4">Số điện thoại người nhận hàng</div>
                        <div class="col-8">{{$order->receiver_phone}}</div>
                    </div>
                    <div class="row">
                        <div class="col-4">Địa chỉ</div>
                        <div class="col-8">{{$order->shipment_address}}</div>
                    </div>
                    <hr/>
                    <h5>Thanh toán</h5>
                    <div class="row">
                        <div class="col-4">Phương thức thanh toán</div>
                        <div class="col-8">{{$order->payment_type}}</div>
                    </div>
                    @if($order->payment_type == 'ATM') 
                    <div class="row">
                        <div class="col-4">Thông tin thanh toán</div>
                        <div class="col-8">{{$order->other_payment_info}}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6">
            <table class="table ">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order_items as $key => $item)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>
                                <div>(Size: {{$item->order_item_size}}, Màu sắc: {{$item->order_item_color}})</div>
                            </td>
                            <td>{{$item->order_item_quantity}}</td>
                            <td>{{$item->order_item_price * $item->order_item_quantity}} VND</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td colspan="2">
                            <b>TỔNG CỘNG</b>
                        </td>
                        <td>{{$total}} VND</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection