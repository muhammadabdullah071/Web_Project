<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Rider Assignments
        Schema::create('rider_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('rider_id')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('assigned'); // assigned, picked_up, delivered
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->timestamps();
        });

        // QR Tables
        Schema::create('qr_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('table_number');
            $table->string('qr_code_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Feedback & Reviews
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        // Complaints
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('category'); // food_quality, delivery_delay, missing_item, etc.
            $table->text('description');
            $table->string('status')->default('pending'); // pending, investigating, resolved, rejected
            $table->text('admin_response')->nullable();
            $table->timestamps();
        });

        // Favorites
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('favoritable'); // favorite a meal or a restaurant
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('feedback');
        Schema::dropIfExists('qr_tables');
        Schema::dropIfExists('rider_assignments');
    }
};
