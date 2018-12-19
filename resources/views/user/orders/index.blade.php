@extends('layouts.main')

@section('content')
<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img">
    <div class="container h-100" >
        <div class="row h-100 align-items-center" >
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>ĐƠN HÀNG CỦA BẠN</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Breadcumb Area End ##### -->

<div class="container">
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Trạng thái</th>
                <th>Tổng tiền (VND)</th>
                <th>Ngày tạo</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>
                    <a href="{{url('/orders/'.$order->id)}}">
                        {{$order->id}}
                    </a>
                </td>
                <td>
                    {{$order->status}}
                </td>
                <td>
                    {{$order->total_amount}}
                </td>
                <td>
                    {{$order->created_at}}
                </td>
                <td>
                    <a href="{{url('/orders/'.$order->id)}}">Xem</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection