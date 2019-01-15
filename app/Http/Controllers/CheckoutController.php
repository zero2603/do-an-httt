<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use \App\Cart;
use \App\Product;
use \App\Stock;
use \App\Order;
use \App\OrderItem;
use \App\Payment;
use \App\Shipment;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index() {
        $user = Auth::user();

        $cartItems = Cart::leftjoin('stock', 'carts.stock_id', '=', 'stock.id')
            ->leftjoin('products', 'products.id', '=', 'stock.product_id')
            ->leftjoin('sizes', 'sizes.id', '=', 'stock.size_id')
            ->leftjoin('colors', 'colors.id', '=', 'stock.color_id')
            ->leftjoin('product_images', function ($join) {
                $join->on('product_images.product_id', '=', 'products.id');
                $join->on(function($query) {
                    $query->take(1); 
                });
            })
            ->where('user_id', '=', $user->id)
            ->select(DB::raw("
                products.*, 
                sizes.name AS size_name, 
                colors.name AS color_name, 
                stock.selling_price AS selling_price, 
                stock.id AS stock_id,
                carts.quantity, 
                product_images.source AS product_image")
            )
            ->groupBy('stock.id')
            ->get();

        $total = 0;
        foreach($cartItems as $item) {
            $total += $item->selling_price * $item->quantity;
        }

        return view('user.checkout', ['user' => $user, 'cartItems' => $cartItems, "total" => $total]);
    }

    public function checkout(Request $request) {
        $user_id = Auth::id();
        $data = $request->all();

        // get all items in cart
        $cartItems = Cart::leftjoin('stock', 'carts.stock_id', '=', 'stock.id')
        ->leftjoin('products', 'products.id', '=', 'stock.product_id')
        ->leftjoin('sizes', 'sizes.id', '=', 'stock.size_id')
        ->leftjoin('colors', 'colors.id', '=', 'stock.color_id')
        ->where('user_id', '=', $user_id)
        ->select(DB::raw("
            products.id AS product_id, 
            products.product_name AS product_name, 
            sizes.name AS size_name, 
            colors.name AS color_name, 
            stock.selling_price AS selling_price, 
            stock.id AS stock_id,
            carts.quantity AS quantity")
        )
        ->get();

        if(count($cartItems) == 0) {
            return view('user.result', ['alert' => 'Lỗi. Giỏ hàng đang rỗng!']);
        }

        $total = 0;
        foreach($cartItems as $item) {
            $total += $item->selling_price;
        }

        // create order 
        $order = Order::create([
            'user_id' => $user_id,
            'status' => 'pending',
            'total_amount' => $total
        ]);

        // create order item
        $temp = [];
        foreach($cartItems as $item) {
            array_push($temp, [
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'order_item_size' => $item->size_name,
                'order_item_color' => $item->color_name,
                'order_item_quantity' => $item->quantity,
                'order_item_price' => $item->selling_price,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);
        }

        OrderItem::insert($temp);

        Cart::where('user_id', $user_id)->delete();

        // create shipment
        $shipment = Shipment::create([
            'order_id' => $order->id,
            'receiver_name' => $data['receiver_name'],
            'receiver_phone' => $data['receiver_phone'],
            'shipment_address' => $data['town_city'].", ".$data['address_1'].", ".$data['address_2']
        ]);

        // create payment
        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_type' =>  $data['payment_type'],
            'other_payment_info' => $data['other_payment_info']
        ]);

        return view("user.result", ['alert' => "", 'order' => $order, 'orderItems' => $cartItems, 'shipment' => $shipment, 'payment' => $payment, 'total' => $total]);
    }
}
