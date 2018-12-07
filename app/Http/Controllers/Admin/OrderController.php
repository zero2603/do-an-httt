<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Order;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::join('users', 'users.id', '=', 'orders.user_id')
            ->select(DB::raw('users.first_name AS user_firstname, users.last_name AS user_lastname, orders.*'))
            ->paginate(10);
        return view('admin.orders.index', ['orders' => $orders]);
    } 
}
