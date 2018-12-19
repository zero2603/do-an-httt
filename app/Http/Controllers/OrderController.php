<?php

namespace App\Http\Controllers;
use \App\Order;
use \App\OrderItem;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::where('user_id', Auth::id())->paginate(10);
        return view('user.orders.index', ['orders' => $orders]);
    }

    public function show($id) {
    $order = Order::join('users', 'users.id', '=', 'orders.user_id')
        ->join('shipments', 'orders.id', '=', 'shipments.order_id')
        ->join('payments', 'orders.id', '=', 'payments.order_id')
        ->select(DB::raw(
            'orders.*, 
            users.first_name AS creator_first_name, users.last_name AS creator_last_name, users.email AS creator_email,
            shipments.receiver_name, shipments.receiver_phone, shipments.shipment_address,
            payments.payment_type, payments.other_payment_info'
        ))
        ->where('orders.id', '=', $id)
        ->first();

        $order_items = OrderItem::where('order_id','=', $id)->get();

        $total = 0;
        foreach($order_items as $item) {
            $total += $item->order_item_price;
        }

        return view('user.orders.detail', ['order' => $order, 'order_items' => $order_items, 'total' => $total]);
    }
}
