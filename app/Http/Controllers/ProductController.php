<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Product;
use \App\Stock;
use \App\ProductCategory;
use \App\Category;
use \App\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
                ->select(DB::raw('products.*, stock.selling_price, categories.name, product_images.source'))
                ->paginate(9);
        } else {
            $products = Product::leftjoin('product_category', 'products.id', '=', 'product_category.product_id')
                ->leftjoin('categories', 'categories.id', '=', 'product_category.category_id')
                ->leftjoin('stock', 'products.id', '=', 'stock.product_id')
                ->leftjoin('product_images', 'products.id', '=', 'product_images.product_id')
                ->groupBy('products.id')
                ->where($query)
                ->select(DB::raw('products.*, stock.selling_price, categories.name, product_images.source'))
                ->paginate(9);
        }
        
        return view('user.products.index', ['products' => $products->appends(Input::except('page')),  'total' => $total]);    
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

        // get comments of product
        $comments = Comment::join('users', 'users.id', '=', 'comments.user_id')
                    ->where('product_id', '=', $id)
                    // ->orderBy('created_at', 'DESC')
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

        $num_of_comments = count($comments);

        return view('user.products.detail', [
            'product' => $product, 
            'current_stock' => $current_stock,
            'comments' => $parents,
            'num_of_comments' => $num_of_comments
        ]);
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

    public function search(Request $request) {
        $products = Product::leftjoin('stock', 'products.id', '=', 'stock.product_id')
                ->leftjoin('product_images', 'products.id', '=', 'product_images.product_id')
                ->groupBy('products.id')
                ->select(DB::raw(
                    'products.*, product_images.source, stock.selling_price'
                ))
                ->where('product_name', 'like', '%'.$request->get('name').'%')
                ->limit(5)
                ->get();

        return $products;
    }

    public function getSubProduct($type) {
        if($type != 'product') {
            $category_id = DB::table('categories')->where('name', '=', $type)->get();
            $products = [];
            $total;
            if (isset($category_id[0])) {
                $product_ids = DB::table('product_category')->where('category_id','=',$category_id[0]->id)->get();
                
                // print_r($product_ids);die();
                foreach ($product_ids as $product_id) {
                    $product = DB::table('products')->where('id','=',$product_id->product_id)->get();
                    $selling_price = DB::table('stock')->where('product_id', '=', $product[0]->id)->value('selling_price');
                    $image = DB::table('product_images')->where('product_id', '=', $product[0]->id)->value('source');
                    $product[0]->selling_price = $selling_price;
                    $product[0]->image = $image;
                    $products[] = $product[0];
                }
            }
            $total = count($products);
            return view('user.products.'.$type ,['products' => $products, 'total' => $total]);
            }
        }

    public function getCategories() {
        $categories = Category::all();
        return ['categories' => $categories];
    }

    public function getAllColors() {
        $colors = \App\Color::all();
        return ['colors' => $colors];
    }

    public function getAllSizes() {
        $sizes = \App\Size::all();
        return ['sizes' => $sizes];
    }
}
