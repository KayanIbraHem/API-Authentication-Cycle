<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrderResource;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function makeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'order_type' => 'required',
            'full_name' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            foreach ((array)$validator->errors() as $error) {
                return response()->json([
                    'status' => 'faild',
                    'message' => 'Please Recheck Your Details',
                    'data' => $error
                ]);
            }
        }
        $user = auth()->user();
        $userCart = Cart::where('user_id', $user->id)->get();
        if ($userCart->count() < 1) {
            return response()->json(['error' => 'cart not found'], 404);
        }
        if ($userCart->count() > 0) {
            $totalPrice = 0;
            foreach ($userCart as $item) {
                $totalPrice += $item->quantity * $item->price;
            }
        }
        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $totalPrice,
                'payment_method' => $request->payment_method,

            ]);
            foreach ($userCart as $item) {
                $orderItems = OrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'size_id' => $item->size_id,
                    'quantity' => $item->quantity,
                    'total' => $item->quantity * $item->price,
                ]);
            }
            OrderAddress::create([
                'order_id' => $order->id,
                'order_type' => $request->order_type,
                'full_name' => $request->full_name,
                'city' => $request->city,
                'address' => $request->address,
            ]);
            if ($userCart->count() > 0) {
                foreach ($userCart as $cartItem) {
                    $cartItem->delete();
                }
            }
            DB::commit();
            return response()->json([
                'status' => 'true',
                'message' => 'order completed successfully!',
                'order' => new OrderResource($order),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return  response()->json(['error' => 'failed to complete order'], 500);
        }
    }
}
