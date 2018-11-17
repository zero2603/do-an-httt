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
        $products =  Product::paginate(8);
        foreach($products as $product) {
            $attribute = Stock::where('product_id', '=', $product->id)->orderBy('selling_price', 'ASC')->first();
            $product->attribute = $attribute;

            $image = DB::table('product_images')->where('product_id', '=', $product->id)->value('source');
            $product->image = $image; 

            $selling_price = DB::table('stock')->where('product_id', '=', $product->id)->value('selling_price');
            $product->selling_price = $selling_price;          
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

        $image = DB::table('product_images')->where('product_id', '=', $id)->value('source');
        $product->image = $image;

        $size_id = DB::table('stock')->where('product_id', '=', $id)->get();
        foreach ($size_id as $item) {
            $size[] = DB::table('sizes')->where('id', '=', $item->size_id)->value('name');
        }
        $product->size = array_unique($size);
        $product->size = array_values($product->size);

        $color_id = DB::table('stock')->where('product_id', '=', $id)->get();
        foreach ($color_id as $item) {
            $color[] = DB::table('colors')->where('id', '=', $item->color_id)->value('name');
        }
        $product->color = array_unique($color);
        $product->color = array_values($product->color);
        // print_r($product->color);die();
        
        $selling_price = DB::table('stock')->where('product_id', '=', $id)->value('selling_price');
        $product->selling_price = $selling_price;

            
        return view('user.products.detail', ['product' => $product]);
    }
}
