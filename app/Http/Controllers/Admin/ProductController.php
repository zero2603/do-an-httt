<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use \App\Product;
use \App\Size;
use \App\Color;
use \App\Category;
use \App\ProductCategory;
use \App\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products =  Product::paginate(10);
        return view('admin.products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
        return view('admin.products.create', ['categories' => $categories, 'sizes' => $sizes, 'colors' => $colors]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create($request->get('product'));

        $categories = $request->get('categories');
        $productCategoryArr = [];
        foreach($categories as $category) {
            array_push($productCategoryArr, ['product_id' => $product->id, 'category_id' => $category]);
        }
        print_r($productCategoryArr);
        ProductCategory::insert($productCategoryArr);
        
        $data = $request->get('attr');
        $attrArray = [];
        $numOfVariants = count($data) / 4;
        for($i = 0; $i < $numOfVariants; $i++) {
            array_push($attrArray, [
                'product_id' => $product->id,
                'size_id' => $data[4*$i], 
                'color_id' => $data[4*$i+1], 
                'buying_price' => $data[4*$i+2], 
                'selling_price' => $data[4*$i+3]
            ]);
        }
        Stock::insert($attrArray);

        $imageArray = [];
        $images = $request->images ? $request->images : [];
       
        foreach($images as $image)  {
            // $extension = $image->getClientOriginalExtension();
            $file = Storage::disk('local')->put('public/images', $image);
            $filename = basename($file);

            array_push($imageArray, [
                'product_id' => $product->id,
                'source' => 'storage/images/'.baseName($file)
            ]);
        }
        DB::table('product_images')->insert($imageArray);

        return redirect('/admin/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('admin.products.detail', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();

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
            
        return view('admin.products.edit', [
            'product' => $product, 
            'categories' => $categories, 
            'sizes' => $sizes,
            'colors' => $colors    
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $data = $request->get('product');

        foreach($data as $key => $value) {
            $product->$key = $value;
        }
        $product->save();

        $categories = $request->get('categories');
        $productCategoryArr = [];
        foreach($categories as $category) {
            array_push($productCategoryArr, ['product_id' => $id, 'category_id' => $category]);
        }
        ProductCategory::where('product_id', '=', $id)->delete();
        ProductCategory::insert($productCategoryArr);
        
        $data = $request->get('attr') ? $request->get('attr') : [];
        $attrArray = [];
        $numOfVariants = count($data) / 4;
        for($i = 0; $i < $numOfVariants; $i++) {
            array_push($attrArray, [
                'product_id' => $id,
                'size_id' => $data[4*$i], 
                'color_id' => $data[4*$i+1], 
                'buying_price' => $data[4*$i+2], 
                'selling_price' => $data[4*$i+3]
            ]);
        }
        Stock::where('product_id', '=', $id)->delete();
        Stock::insert($attrArray);
        return redirect('/admin/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        DB::table('product_category')->where('product_id', '=', $id)->delete();
        DB::table('stock')->where('product_id', '=', $id)->delete();
        return redirect('admin/products');
    }

    /**
     *  Add product image 
     */
    public function addImage(Request $requet, $id) {
        $imageArray = [];
        $images = $request->images ? $request->images : [];
       
        foreach($images as $image)  {
            // $extension = $image->getClientOriginalExtension();
            $file = Storage::disk('local')->put('public/images', $image);
            $filename = basename($file);

            array_push($imageArray, [
                'product_id' => $id,
                'source' => 'storage/images/'.baseName($file)
            ]);
        }
        DB::table('product_images')->insert($imageArray);
    }

    /**
     *  Remove product image 
     */
    public function removeImage($id) {
        $image = DB::table('product_images')->find($id);
        
    }
}
