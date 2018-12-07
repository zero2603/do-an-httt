@extends('layouts.admin')

@section('content')

<h1 class="page-header">{{__('Tất cả đơn hàng')}}</h1>  
<div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên khách hàng</th>
                <th>Trạng thái</th>
                <th>Tổng tiền (VND)</th>
                <th>Ngày tạo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>
                    <a href="{{url('admin/order/'.$order->id)}}">
                        {{$order->id}}
                    </a>
                </td>
                <td>
                    <a href="{{url('admin/users/'.$order->user_id.'/edit')}}">
                        {{$order->user_firstname}} {{$order->user_lastname}}
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
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}
</div>


@endsection