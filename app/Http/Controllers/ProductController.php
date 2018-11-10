<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Product;
use \App\Stock;
use \App\ProductCategory;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products =  Product::paginate(12);
        foreach($products as $product) {
            $attribute = Stock::where('product_id', '=', $product->id)->orderBy('selling_price', 'ASC')->first();
            $product->attribute = $attribute;

            $images = DB::table('product_images')->where('product_id', '=', $product->id)->take(2)->get();
            $product->images = $images;
        }
        return view('user.products.index', ['products' => $products]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        $productCategories = ProductCategory::where('product_id', '=', $id)->get();
        $temp = [];
        foreach($productCategories as $item) {
            array_push($temp, $item->category_id);
        }
        $product->categories = $temp;

        $attributes = Stock::where('product_id', '=', $id)->get();
        $product->attributes = $attributes;

        $images = DB::table('product_images')->where('product_id', '=', $id)->get();
        $product->images = $images;
            
        return view('user.products.detail', ['product' => $product]);
    }
}
