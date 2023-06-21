<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\User;
use App\Models\Coupon;
use App\Models\CartItems;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\Product\ProductStoreRequest;

class CartController extends Controller
{
    public function addAOrUpdateToCart(ProductStoreRequest $request)
    {
        $validator = $request->validated();
        $user = auth()->user();
        $product_id = $request->input('product_id');
        $size_id = $request->input('size_id');
        //check if product exists
        $data = ProductSize::where('product_id', $product_id)->where('size_id', $size_id)->first();
        if (!$data) {
            return response()->json(['error' => 'Product not available!'], 400);
        }
        //get user cart
        $cart = Cart::where('user_id', $user->id)->where('status', 0)->first();
        //check if cart exists and create
        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id]);
        }
        //get cart item's and create
        $cartItems = $cart->items()->where([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'size_id' => $request->size_id,
            'cart_id' => $cart->id
        ])->first();
        if ($cartItems) {
            $cartItems->quantity = $request->quantity;
            $cartItems->total = $cartItems->quantity * $cartItems->price;
            $cartItems->update();
        } else {
            $cartItems = CartItems::create([
                'cart_id' => $cart->id,
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'size_id' => $request->size_id,
                'quantity' => $request->quantity,
                'price' => $data->price,
                'total' => $data->price * $request->quantity,
            ]);
        }

        //check coupon and create discount
        $total = $cart->cartTotal();
        if ($cart->coupon_id !== null) {
            $coupon = Coupon::where('id', $cart->coupon_id)->first();
            $cartMinimum = $coupon->minimum_of_total;
            $discount = $coupon->discount($total);
            if ($total >= $cartMinimum) {
                if ($discount > $coupon->max_discount) {
                    $cart->discount = $coupon->max_discount;
                } else {
                    $cart->discount = $discount;
                    $total = $cart->totalWithDiscount();
                }
            } else {
                $cart->discount = 0;
                $total = $cart->cartTotal();
            }
        }
        $cart->update(['total' => $total]);
        return response()->json([
            'message' => 'Product added to cart',
            'cart' => $user->cartItems(),
        ]);
    }

    public function removeProduct(Request $request)
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', auth()->id())->where('status', 0)->first();
        if (!$cart) {
            return response()->json(['error' => 'no cart nto remove product'], 404);
        }
        $cartItem = CartItems::where([
            'cart_id' => $cart->id,
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'size_id' => $request->size_id,
        ])
            ->first();
        if (!$cartItem) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $cartItem->delete();
        $total = $cart->cartTotal();

        $coupon = Coupon::where('id', $cart->coupon_id)->first();
        if ($coupon) {
            $cartMinimum = $coupon->minimum_of_total;
            $discount = $coupon->discount($total);
            if ($total >= $cartMinimum) {
                if ($discount > $coupon->max_discount) {
                    $cart->discount = $coupon->max_discount;
                } else {
                    $cart->discount = $discount;
                    $total = $cart->totalWithDiscount();
                }
            } else {
                $cart->discount = 0;
                $total = $cart->cartTotal();
            }
        }
        $cart->update(['total' => $total]);
        return response()->json([
            'status' => 'true',
            'message' => 'prdouct removed',
            'cart' => $user->cartItems(),
        ]);
    }

    public function clearCart()
    {
        $cart = Cart::where('user_id', auth()->id())->where('status', 0)->first();
        if (!$cart) {
            return response()->json([
                'status' => 'faild',
                'message' => 'Cart not found'
            ], 404);
        }
        $cart->delete();
        $cart->items()->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'Cart removed',
        ]);
    }

    public function showCart(Request $request)
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->where('status', 0)->first();
        if (!$cart) {
            return response()->json([
                'message' => 'cart not found!',
            ], 404);
        }
        if ($cart->items->count() < 1) {
            return response()->json([
                'message' => 'empty cart!',
            ], 404);
        }
        return response()->json([
            'status' => 'true',
            'cart' => $user->cartItems(),
        ]);
    }
}
