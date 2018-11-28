<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use \App\Cart;
use \App\Product;
use \App\Stock;
use \App\ProductCategory;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function getCart() {
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
            ->where('user_id', '=', Auth::id())
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
        return ['cart' => $cartItems];
    }

    public function add(Request $request) {
        // print_r($request->get('stock_id'));
        $cart = Cart::create([
            'user_id' => Auth::id(),
            'stock_id' => $request->get('stock_id'),
            'quantity' => 1
        ]);
        // return ['cart' => $cart];
        return redirect()->back()->with(['cart' => $cart]);
    }

    public function remove($stock_id) {
        $cart = Cart::where([
            'user_id' => Auth::id(),
            'stock_id' => $request->stock_id,
        ])->delete();

        return ['cart' => $cart];
    }

    public function changeQuantity(Request $request) {

        if($request->type == 'plus') {
            $result = Cart::where([
                'user_id' => Auth::id(),
                'stock_id' => $request->stock_id,
            ])
            ->update(['quantity'=> DB::raw('quantity+1')]);
        }
        if($request->type == 'minus') {
            $result = Cart::where([
                'user_id' => Auth::id(),
                'stock_id' => $request->stock_id,
            ])
            ->update(['quantity'=> DB::raw('quantity-1')]);
        }
        
        if($result) {
            $item = Cart::where([
                'user_id' => Auth::id(),
                'stock_id' => $request->stock_id,
            ])->first();
            return ['item' => $item];
        }
    }
}
