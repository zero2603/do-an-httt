<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use \App\Product;
use \App\Size;
use \App\Color;
use \App\Category;
use \App\ProductCategory;
use \App\ProductImage;
use \App\Stock;
use \App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{
    public function __construct()
    {
        // $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all(); 

        $total = 10;
        $query = $request->all();
        unset($query['page']);
        $name = null;

        if(array_key_exists('name', $query)) {
            $name = $query['name'];
            unset($query['name']);
        }

        if($name) {
            $products = Product::leftjoin('product_category', 'products.id', '=', 'product_category.product_id')
                ->leftjoin('categories', 'categories.id', '=', 'product_category.category_id')
                ->leftjoin('stock', 'products.id', '=', 'stock.product_id')
                ->leftjoin('product_images', 'products.id', '=', 'product_images.product_id')
                ->groupBy('products.id')
                ->where($query)
                ->where('product_name', 'like', '%'.$name.'%')
                ->select(DB::raw('products.*, categories.name AS category_name, product_images.source, stock.selling_price'))
                ->paginate(9);
        } else {
            $products = Product::leftjoin('product_category', 'products.id', '=', 'product_category.product_id')
                ->leftjoin('categories', 'categories.id', '=', 'product_category.category_id')
                ->leftjoin('stock', 'products.id', '=', 'stock.product_id')
                ->leftjoin('product_images', 'products.id', '=', 'product_images.product_id')
                ->groupBy('products.id')
                ->where($query)
                ->select(DB::raw('products.*, categories.name AS category_name, product_images.source, stock.selling_price'))
                ->paginate(10);
        }
        
        return view('admin.products.index', [
            'products' => $products->appends(Input::except('page')), 
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes    
        ]);
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

        $comments = Comment::join('users', 'users.id', '=', 'comments.user_id')
                    ->where('product_id', '=', $id)
                    ->orderBy('created_at', 'DESC')
                    ->select(DB::raw('comments.*, 
                        users.first_name AS user_first_name, 
                        users.last_name AS user_last_name, 
                        users.avatar AS user_avatar'))
                    ->get();
        $parents = [];
        $children = [];
        foreach($comments as $comment) {
            // if parent_comment_id is null, comment is parent
            if(!$comment->parent_comment_id) {
                array_push($parents, $comment);
            } else {
                array_push($children, $comment);
            }
        }
        foreach($parents as $parent) {
            $temp = [];
            foreach($children as $child) {
                if($child->parent_comment_id == $parent->id) {
                    array_push($temp, $child);
                }
            }
            $parent->reply = $temp;
        }
            
        return view('admin.products.edit', [
            'product' => $product, 
            'categories' => $categories, 
            'sizes' => $sizes,
            'colors' => $colors,
            'comments' => $parents,
            'number_of_comments' => count($comments)    
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
        return redirect()->back();
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
        Comment::where('product_id', '=', $id)->delete();
        return redirect('admin/products');
    }

    /**
     *  Add product image 
     */
    public function addImage(Request $request) {
        $imageArray = [];
        $product_id = $request->get('product_id');
        $images = $request->images ? $request->images : [];
       
        foreach($images as $image)  {
            // $extension = $image->getClientOriginalExtension();
            $file = Storage::disk('local')->put('public/images', $image);

            $newImage = new ProductImage;
            $newImage->product_id = $product_id;
            $newImage->source = 'storage/images/'.baseName($file);
            $newImage->save();
            array_push($imageArray, $newImage);
        }
        // $result = DB::table('product_images')->insert($imageArray);
        return redirect()->back();
    }

    /**
     *  Remove product image 
     */
    public function removeImage($id) {
        $query = DB::table('product_images')->where('id', '=', $id);
        $image = $query->first();
        
        if ($query->delete()) {
            Storage::disk('local')->delete($image->source);
            return json_encode(true);
        } else {
            return json_encode(false);
        }
    }
}
