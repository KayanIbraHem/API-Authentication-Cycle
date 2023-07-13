<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderContorller extends Controller
{
    public function index()
    {
        
        return $orders = Cart::all();
    }

    public function show()
    {
    }
}
