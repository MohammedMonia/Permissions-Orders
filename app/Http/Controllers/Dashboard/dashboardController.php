<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\User;
use App\Category;
use App\Client;
use App\Order;

class dashboardController extends Controller
{
    
    public function index()
    {
        $categories_count = Category::count();
        $products_count = Product::count();
        $clients_count = Client::count();
        $orders_count = Order::count();
        $users_count = User::whereRoleIs('admin')->count();


        $sales_data = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as sum')
        )->groupBy('month')->get();

        return view('dashboard.index', compact('categories_count', 'products_count', 'orders_count', 'users_count', 'clients_count', 'sales_data'));
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
