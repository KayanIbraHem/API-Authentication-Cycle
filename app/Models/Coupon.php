<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';
    protected $fillable = [
        'code',
        'type',
        'type_of_use',
        'max_uses',
        'value',
        'precent_off',
        'max_discount',
        'minimum_of_total',
        'current_uses',
        'start_date',
        'expiry_date',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'carts', 'coupon_id', 'user_id');
    }

    public static function findByCode($code)
    {
        return self::where('code', $code)->first();
    }

    public function hasBeenUsedBy(User $user)
    {
        return $this->carts()->where('user_id', $user->id)->exists();
    }

    public function discount($total)
    {
        if ($this->type == 'fixed') {
            return $this->value;
        } elseif ($this->type == 'precent') {
            return ($this->precent_off / 100) * $total;
        } else {
            return 0;
        }
    }

    public function isValid()
    {
        if ($this->is_active == 1) {
            return false;
        }

        if ($this->current_uses >= $this->max_uses) {
            return false;
        }

        $now = Carbon::now();

        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        if ($this->expiry_date && $now->gt($this->expiry_date)) {
            return false;
        }

        return true;
    }
}
