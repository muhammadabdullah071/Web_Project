<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Create Restaurants Table
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('banner')->nullable();
            $table->string('address')->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->time('opening_time')->default('09:00');
            $table->time('closing_time')->default('23:00');
            $table->integer('delivery_time')->default(30); // in minutes
            $table->decimal('min_order', 10, 2)->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Add restaurant_id to products (Food Items)
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('restaurant_id')->nullable()->after('category_id')->constrained()->onDelete('cascade');
            $table->boolean('is_available')->default(true)->after('is_active');
            $table->integer('preparation_time')->default(20)->after('is_available');
        });

        // 3. Update orders table for food delivery
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('restaurant_id')->nullable()->after('user_id')->constrained()->onDelete('cascade');
            $table->decimal('delivery_fee', 10, 2)->default(0)->after('total');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('delivery_fee');
            $table->string('order_type')->default('delivery')->after('status'); // delivery, pickup
        });

        // 4. Update users table for roles
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('customer')->after('is_admin');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('restaurant_id');
            $table->dropColumn(['delivery_fee', 'tax_amount', 'order_type']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('restaurant_id');
            $table->dropColumn(['is_available', 'preparation_time']);
        });

        Schema::dropIfExists('restaurants');
    }
};
