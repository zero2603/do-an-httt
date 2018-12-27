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
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>
                    <a href="{{url('admin/orders/'.$order->id)}}">
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
                <td>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{url('admin/orders/'.$order->id)}}">
                                <button type="button" class="btn btn-sm btn-primary">Xem</button>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-sm btn-danger" onclick="remove({{$order->id}});">
                                Xóa
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form method="POST" class="d-none" id="delete-order-form">
        @method('DELETE')
        {{ csrf_field() }}
    </form>

    {{ $orders->links() }}
</div>

<script>
    var form = document.getElementById("delete-order-form");
    function remove(id) {
        let url = `{{url('/')}}/admin/orders/` + id;
        if(confirm("Bạn có chắc chắn muốn xóa?")) {
            form.setAttribute('action', url);
            form.submit();
        }
    }
</script>

@endsection