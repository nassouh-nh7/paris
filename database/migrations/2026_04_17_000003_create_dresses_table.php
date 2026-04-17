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
        Schema::create('dresses', function (Blueprint $table): void {
            $table->string('id')->primary();
            $table->string('title');
            $table->text('description');
            $table->json('image_urls');
            $table->json('sizes');
            $table->json('colors');
            $table->string('occasion');
            $table->string('condition');
            $table->string('seller_type');
            $table->decimal('rent_price', 10, 2)->default(0);
            $table->decimal('buy_price', 10, 2)->default(0);
            $table->string('listing_mode');
            $table->string('store_id')->nullable();
            $table->string('individual_seller_name')->nullable();
            $table->string('seller_email')->nullable();
            $table->string('seller_phone')->nullable();
            $table->string('seller_location')->nullable();
            $table->unsignedInteger('popularity_score')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dresses');
    }
};
