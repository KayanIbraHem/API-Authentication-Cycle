<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'token',
        'phone_verification_code'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userCart()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'carts', 'user_id', 'coupon_id');
    }
    
    public function cart()
    {
        return $this->userCart()->where('status', '0')->get();
    }

    public function cartItems()
    {
        $cartItems = $this->cart();
        $cartItemsArray = [];
        $totalPrice = 0;
        $discount = 0;
        foreach ($cartItems as $cartItem) {
            foreach ($cartItem->items as $item) {
                $cartItemsArray[] = [
                    'id' => $item->id,
                    'product' => $item->products->name,
                    'size' => $item->ProductSizes->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'total' => $item->total,
                ];
                $totalPrice += $item->price * $item->quantity;
                $discount = $cartItem->discount;
            }
        }
        return [
            'cartItems' => $cartItemsArray,
            'total' => $totalPrice,
            'discount' => $discount,
            'totalAfterDiscount' => $totalPrice - $discount,
        ];
    }
}
