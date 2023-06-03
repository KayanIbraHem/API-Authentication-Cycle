<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CartItemResource;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'size_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
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
            'size_id' => $request->size_id
        ])
            ->first();
        if (!$cartItems) {
            $cart = Cart::Create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'size_id' => $request->size_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]);
            return response()->json([
                'status' => 'true',
                'message' => 'product added to cart successfully',
                'cart' => new CartItemResource($cart)
            ]);
        }
        $cartItems->quantity += $request->quantity;
        $cartItems->update();
        return response()->json([
            'status' => 'true',
            'message' => 'cart updated successfully',
            'cart' => new CartItemResource($cartItems)
        ]);
    }

    public function updateCart(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'size_id' => 'required',
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
            'product_id' => $request->product_id,
            'size_id' => $request->size_id,
        ])
            ->first();
        if (!$cart) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $quantity = $cart->quantity;
        if ($request->action == 'increase') {
            $quantity += 1;
        } else {
            if ($quantity > 1) {
                $quantity -= 1;
            }
        }
        $cart->update(['quantity' => $quantity]);
        return response()->json([
            'status' => 'true',
            'message' => 'product quantity updated',
            'cart' => new CartItemResource($cart)
        ]);
    }

    public function removeProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'size_id' => 'required',
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
        $cartItem = Cart::where([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'size_id' => $request->size_id,
        ])
            ->first();
        if (!$cartItem) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $cartItem->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'prdouct removed',
            'cart' => $cartItem,
        ]);
    }

    public function clearCart()
    {
        $user = auth()->user();
        $cartItems = Cart::where('user_id', $user->id)->get();
        if ($cartItems->count() > 0) {
            foreach ($cartItems as $cartItem) {
                $cartItem->delete();
            }
            return response()->json([
                'status' => 'true',
                'message' => 'Cart removed',
            ]);
        }
        return response()->json([
            'status' => 'faild',
            'message' => 'Cart not found'
        ], 404);
    }

    public function showCart()
    {
        $user = auth()->user();
        $cartItems = Cart::where('user_id', $user->id)->get();
        if ($cartItems->count() > 0) {
            $totalPrice = 0;
            foreach ($cartItems as $item) {
                $totalPrice += $item->quantity * $item->price;
            }
            return response()->json([
                'status' => 'true',
                'cart' => CartItemResource::collection($cartItems),
                'totalPrice' => $totalPrice,
            ]);
        }
        return response()->json([
            'status' => 'true',
            'message' => 'Fill in the cart to view the products',
        ]);
    }
}

        // DB::beginTransaction();

        // try {
        //     // Update user balance
        //     $user = User::find($request->user_id);
        //     $user->balance -= $request->amount;
        //     $user->save();

        //     // Create new transaction record
        //     $transaction = new Transaction();
        //     $transaction->user_id = $request->user_id;
        //     $transaction->amount = $request->amount;
        //     $transaction->save();

        //     DB::commit();
        //     return response()->json(['message' => 'Balance updated successfully'], 200);
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return response()->json(['error' => 'Failed to update balance'], 500);
        // }
