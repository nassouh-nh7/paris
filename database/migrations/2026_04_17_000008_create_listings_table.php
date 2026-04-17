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
        Schema::create('listings', function (Blueprint $table): void {
            $table->string('id')->primary();
            $table->string('owner_user_id')->index();
            $table->string('title');
            $table->text('description');
            $table->string('occasion');
            $table->json('sizes');
            $table->string('condition');
            $table->decimal('rent_price', 10, 2)->default(0);
            $table->decimal('buy_price', 10, 2)->default(0);
            $table->string('listing_mode');
            $table->json('network_image_urls');
            $table->json('local_image_paths');
            $table->json('rental_blocked_dates');
            $table->string('status')->default('active');
            $table->boolean('is_rented_out')->default(false);
            $table->boolean('is_sold')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
