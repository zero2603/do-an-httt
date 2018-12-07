@extends('layouts.main')

@section('content')

<div class="container mb-4">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Thông tin giao hàng</h5>
                    <form method="POST" action="{{url('/checkout')}}" novalidate>
                        @csrf
                        <div class="form-group">
                            <label>Họ tên người nhận hàng</label>
                            <input type="text" class="form-control" name="receiver_name" value="{{$user->first_name." ".$user->last_name}}" required/>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại người nhận hàng</label>
                            <input type="number" class="form-control" name="receiver_phone" value="{{$user->phone_number}}" required/>
                        </div>
                        <div class="form-group">
                            <label>Tỉnh / Thành phố</label>
                            <input type="text" class="form-control" name="town_city" value="{{$user->town_city}}" required/>
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" class="form-control" name="address_1" value="{{$user->address1}}" required/>
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ 2</label>
                            <input type="text" class="form-control" name="address_2" value="{{$user->address2}}"/>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <h5>Chọn phương thức thanh toán</h5>
                            <div class="form-check">
                                <input type="radio" name="payment_type" class="form-check-input" value="COD" required onclick="removeOtherInfo();"/>
                                <label class="form-check-label">
                                    Ship COD
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="payment_type" class="form-check-input" value="ATM" required onclick="showOtherInfo();"/>
                                <label class="form-check-label">
                                    Thanh toán ATM
                                </label>
                            </div>
                        </div>
                        <div class="form-group d-none" id="other_payment_info">
                            <label>Thông tin thẻ ATM</label>
                            <textarea class="form-control" name='other_payment_info' id="card-info"></textarea>
                        </div>
                        <button class="btn btn-primary float-right" type="submit">
                            Xác nhận thanh toán
                        </button>
                    </form>
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
                    @foreach ($cartItems as $key => $item)
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
        </div>
    </div>
</div>

<script>
function showOtherInfo() {
    document.getElementById("other_payment_info").classList.remove("d-none");
    document.getElementById("card-info").setAttribute('required', "true");
}

function removeOtherInfo() {
    document.getElementById("other_payment_info").classList.add("d-none");
    document.getElementById("card-info").setAttribute('required', "false");
}
</script>

@endsection