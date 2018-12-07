@extends('layouts.main')

@section('content')

<div class="container mb-4">
    @if ($alert)
        <div class="alert alert-danger">
            {{ $alert }}
        </div>
        <div class="mt-4">
            <a href="{{url("/")}}">
                <button class="btn btn-danger">Mua hàng ngay</button>
            </a>
        </div>
    @else
    <h2 class="page-header">
        Thông tin đơn hàng
    </h2>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mã số đơn hàng: #{{$order->id}}</h5>
                    <h5 class="card-title">Thông tin giao hàng</h5>
                    <div class="row">
                        <div class="col-4">Người nhận hàng</div>
                        <div class="col-8">{{$shipment->receiver_name}}</div>
                    </div>
                    <div class="row">
                        <div class="col-4">Số điện thoại người nhận hàng</div>
                        <div class="col-8">{{$shipment->receiver_phone}}</div>
                    </div>
                    <div class="row">
                        <div class="col-4">Địa chỉ</div>
                        <div class="col-8">{{$shipment->shipment_address}}</div>
                    </div>
                    <hr/>
                    <h5>Thanh toán</h5>
                    <div class="row">
                        <div class="col-4">Phương thức thanh toán</div>
                        <div class="col-8">{{$payment->payment_type}}</div>
                    </div>
                    @if($payment->payment_type == 'ATM') 
                    <div class="row">
                        <div class="col-4">Thông tin thanh toán</div>
                        <div class="col-8">{{$payment->other_payment_info}}</div>
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
                    @foreach ($orderItems as $key => $item)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>
                                <div><b>{{$item->product_name}}</b></div>
                                <div>(Size: {{$item->size_name}}, Màu sắc: {{$item->color_name}})</div>
                            </td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->selling_price * $item->quantity}} VND</td>
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
            <div class="mt-4">
                <a href="{{url("/")}}">
                    <button class="btn btn-danger">Tiếp tục mua hàng</button>
                </a>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection