<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Product;
use \App\Stock;
use \App\ProductCategory;
use \App\Category;
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
        $current_stock = null;
        $product = Product::findOrFail($id);

        $product->categories = Category::leftjoin('product_category', 'product_category.category_id', '=', 'categories.id')
            ->where('product_id', '=', $id)
            ->select(DB::raw('categories.*'))
            ->get();

        $product->images = DB::table('product_images')->where('product_id', '=', $id)->get();

        $stocks = Stock::leftjoin('sizes', 'stock.size_id', '=', 'sizes.id')
            ->leftjoin('colors', 'stock.color_id', '=', 'colors.id')
            ->where('product_id', '=', $id)
            ->select(DB::raw('stock.*, sizes.name AS size_name, colors.name AS color_name'))
            ->get();
        $stocks =  $stocks->toArray();

        // sizes
        $tempSize = [];
        foreach($stocks as $stock) {
            array_push($tempSize, (object)['id' => $stock['size_id'], 'name' => $stock['size_name']]);
        }
        $product->sizes = array_unique($tempSize, SORT_REGULAR);

        // colors
        $tempColor = [];
        foreach($stocks as $stock) {
            if($stock['size_id'] == $product->sizes[0]->id) {
                array_push($tempColor, (object)['id' => $stock['color_id'], 'name' => $stock['color_name']]);
            }
        }
        $product->colors = array_unique($tempColor, SORT_REGULAR);

        // price and current stock
        foreach($stocks as $stock) {
            if($stock['size_id'] == $product->sizes[0]->id && $stock['color_id'] == $product->colors[0]->id) {
                $product->selling_price = $stock['selling_price'];
                $current_stock = $stock['id'];
            }
        }

        return view('user.products.detail', ['product' => $product, 'current_stock' => $current_stock]);
    }

    function getColors(Request $request) {
        $stocks = Stock::leftjoin('colors', 'colors.id', '=', 'stock.color_id')
        ->where([
            ['size_id', '=', $request->get('size_id')],
            ['product_id', '=', $request->get('product_id')]
        ])
        ->select(DB::raw('stock.*, colors.name AS color_name'))
        ->get();

        $tempColor = [];
        foreach($stocks as $stock) {
            array_push($tempColor, (object)['id' => $stock['color_id'], 'name' => $stock['color_name']]);
        }
        return ['colors' => $tempColor, 'current_stock' => $stocks[0]->id, 'selling_price' => $stocks[0]->selling_price];
    }

    function getPrice(Request $request) {
        $stock = Stock::where([
            ['size_id', '=', $request->get('size_id')],
            ['color_id', '=', $request->get('color_id')],
            ['product_id', '=', $request->get('product_id')]
        ])
        ->first();
        return ['selling_price' => $stock->selling_price, 'current_stock' => $stock->id];
    }
}
