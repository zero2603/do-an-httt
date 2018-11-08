<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use \App\Product;
use \App\Size;
use \App\Color;
use \App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
        DB::table('product_category')->insert($productCategoryArr);
        
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
        DB::table('stock')->insert($attrArray);
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
        $product = Product::findOrFail($id);
        $attributes = DB::table('stock')
            ->leftjoin('sizes', 'size.id', '=', 'stock.size_id')
            ->leftjoin('colors', 'color.id', '=', 'stock.color_id')
            ->where('product_id', '=', $id)
            ->select(DB::raw(`
                sizes.name as size,
                colors.name as color,
                buying_price,
                selling_price
            `))
            ->get();
        
        $product->attributes = $attributes;
            
        return view('admin.products.edit', ['product' => $product]);
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
        $data = request()->except(['_token', '_method']);

        foreach($data as $key => $value) {
            $product->$key = $value;
        }
        $product->save();
        return redirect('admin/products');
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
        return redirect('admin/products');
    }
}
