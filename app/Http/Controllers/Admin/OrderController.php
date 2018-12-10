<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\OrderItem;
use App\Payment;
use App\Shipment;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::join('users', 'users.id', '=', 'orders.user_id')
            ->select(DB::raw('users.first_name AS user_firstname, users.last_name AS user_lastname, orders.*'))
            ->paginate(10);
        return view('admin.orders.index', ['orders' => $orders]);
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
        return view('admin.orders.detail', ['order' => $order, 'order_items' => $order_items]);
    }

    public function update(Request $request, $id) {
        $order = Order::find($id);
        $order->status = $request->get('status');
        $order->save();
        return redirect('/admin/orders/'.$id);
    }

    public function destroy($id) {
        Order::destroy($id);
        OrderItem::where('order_id', $id)->delete();
        Shipment::where('order_id', $id)->delete();
        Payment::where('order_id', $id)->delete();
        return redirect('/admin/orders');
    }
}
