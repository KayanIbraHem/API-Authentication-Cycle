<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'size_id' => 'required',
            'quantity' => 'required',
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
        $cartItems = Cart::where([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'size_id' => $request->size_id,
        ])
            ->first();
        if (!$cartItems) {
            $cart = Cart::Create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'size_id' => $request->size_id,
                'quantity' => $request->quantity,
            ]);
            return response()->json(
                ['cart' => $cart]
            );
        }
        $cartItems->quantity += $request->quantity;
        $cartItems->update();
        return response()->json(
            ['cart' => $cartItems]
        );
    }

    public function updateCart($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'product_id' => 'required',
            'size_id' => 'required',
            // 'quantity' => 'required',
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
        $cart = Cart::where([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'size_id' => $request->size_id,
        ])
            ->first();
        $quantity = $cart->quantity;
        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        if ($request->action == 'increase') {
            $quantity += 1;
        } else {
            if ($quantity > 1) {
                $quantity -= 1;
            }
        }
        $cart->update(['quantity' => $quantity]);
        return response()->json(
            ['cart' => $cart]
        );
    }

    public function clearCart(Request $request)
    {
    }
}
