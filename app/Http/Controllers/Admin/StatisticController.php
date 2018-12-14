<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use \App\Product;
use \App\User;
use \App\Order;
use \App\OrderItem;
use \App\Category;

class StatisticController extends Controller
{
    public function index() {
        $product_numbers = Product::count();
        $category_numbers = Category::count();
        $user_numbers = User::count();

        return view('admin.index', ['user_numbers' => $user_numbers, 'category_numbers' => $category_numbers, 'product_numbers' => $product_numbers]);
    }

    public function getRevenue(Request $request) {
        $month = (int) $request->get('month');

        $orderItems = OrderItem::where(DB::raw('month(created_at)'), '=', $month)
            ->select(DB::raw(
                'SUM(order_item_quantity * order_item_price) AS revenue, day(created_at) AS day'
            ))
            ->groupBy(DB::raw('day(created_at)'))
            ->get();
        
        $daysInMonth = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];
        if(in_array($month, [4,6,9,11])) {
            $daysInMonth = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30];
        } else if($month == 2) {
            $daysInMonth = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29];
        }

        $temp = [];
        $data = [];
        foreach($orderItems as $item) {
            array_push($temp, $item->day);
            array_push($data, [$item->day, $item->revenue]);
        }
        $diff = array_diff($daysInMonth, $temp);
        
        foreach($diff as $item) {
            array_push($data, [$item, 0]);
        }

        usort($data, function($a, $b) {
            return $a[0] > $b[0];
        });
        return ['data' => $data];
    }
}
