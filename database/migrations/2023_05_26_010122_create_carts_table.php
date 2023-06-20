<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('coupon_id')->nullable()->references('id')->on('coupons')->onDelete('cascade');
            $table->string('discount')->nullable();
            $table->boolean('status')->default(0);
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('payment_method')->default('cash');
            $table->float('total', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
