<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping', 10, 2)->default(0);
            $table->decimal('platform_fee', 10, 2)->default(500.00);
            $table->decimal('total', 10, 2);
            $table->string('status')->default('pending'); // pending, preparing, ready, out_for_delivery, delivered, cancelled // pending, processing, shipped, delivered, cancelled
            $table->string('payment_method')->default('cod');
            $table->string('payment_status')->default('unpaid');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('zip_code');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
