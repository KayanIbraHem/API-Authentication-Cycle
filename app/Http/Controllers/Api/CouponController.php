<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Coupon\CouponRequest;

class CouponController extends Controller
{
    public function applyPromoCode(CouponRequest $request)
    {
        $promoCode = $request->validated();
        $cart = Cart::with('items')->where('user_id', auth()->id())->where('status', 0)->first();
        $coupon = Coupon::where('code', $promoCode['promo_code'])->first();
        if (!$cart) {
            return response()->json([
                'message' => 'Cart not found'
            ], 404);
        }
        if ($coupon) {
            if (!$coupon->isvalid()) {
                return response()->json([
                    'message' => 'Coupon expired.'
                ], 400);
            }
            if ($coupon->hasBeenUsedBy(auth()->user())) {
                return response()->json([
                    'message' => 'تم استخدام الكوبون من قبل'
                ], 404);
            }
            $cartMinimum = $coupon->minimum_of_total;
            $total = $cart->cartTotal();

            if ($total < $cartMinimum) {
                return response()->json([
                    'error' => 'اجمالي السله اقل من الحد الادني للخصم'
                ], 400);
            }
        }
        $discount = $coupon->discount($total);
        if ($discount < $coupon->max_discount) {
            $total -= $discount;
        } else {
            $discount = $coupon->max_discount;
            $total -= $discount;
        }
        $cart->coupon_id = $coupon->id;
        $cart->discount = $discount;
        $cart->total = $total;
        $cart->save();
        $coupon->current_uses += 1;
        $coupon->save();
        return response()->json([
            'message' => 'Promo code applied',
            'discount' => $cart->discount,
            'total' => $total,
        ]);
    }
    public function removePromoCode(Request $request)
    {
        $cart = Cart::with('items')->where('user_id', auth()->id())->where('status', 0)->first();

        if (!$cart) {
            return response()->json([
                'message' => 'Cart not found'
            ], 404);
        }
        $coupon = Coupon::where('id', $cart->coupon_id)->first();
        if ($coupon) {
            $total = $cart->cartTotal();
            $cart->coupon_id = null;
            $cart->discount = 0;
            $cart->total = $total;
            $cart->save();
            $coupon->current_uses -= 1;
            $coupon->save();
            return response()->json([
                'message' => 'Promo code removed',
                'discount' => 0,
                'total' => $total,
            ]);
        } else {
            return response()->json([
                'message' => 'Promo code not found !',

            ]);
        }
    }
}
