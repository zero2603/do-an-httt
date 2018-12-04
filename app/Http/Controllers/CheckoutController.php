<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use \App\Cart;
use \App\Product;
use \App\Stock;
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
            ->get();

        $total = 0;
        foreach($cartItems as $item) {
            $total += $item->selling_price * $item->quantity;
        }

        return view('user.checkout', ['user' => $user, 'cartItems' => $cartItems, "total" => $total]);
    }
}
