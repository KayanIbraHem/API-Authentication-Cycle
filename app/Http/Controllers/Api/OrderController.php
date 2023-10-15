<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Admin;
use App\Models\Order;
use App\Events\EmptyCart;
use App\Models\OrderItems;
use App\Events\OrderCreated;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\OrderNotification;
use App\Http\Resources\Api\OrderResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\Order\OrderStoreRequest;

class OrderController extends Controller
{

    public function makeOrder(OrderStoreRequest $request)
    {
        $validator = $request->validated();
        $user = auth()->user();
        $userCart = Cart::where('user_id', $user->id)->where('status', 0)->first();
        if (!$userCart) {
            return response()->json(['error' => 'cart not found'], 404);
        }
        if ($userCart->items->count() < 1) {
            return response()->json([
                'message' => 'empty cart!',
            ], 404);
        }
        $userCart->update([
            'full_name' => $request->full_name,
            'city' => $request->city,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'status' => 1,
        ]);
        event(new OrderCreated($userCart));
        // $admin = Admin::where('id', 1)->first();
        // return $admin;
        // $admin->notify(new OrderNotification($userCart));
        return response()->json([
            'status' => 'true',
            'message' => 'order completed successfully!',
            'total' => $userCart->total,
        ]);
    }
}
