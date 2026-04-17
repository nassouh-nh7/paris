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
        Schema::create('orders', function (Blueprint $table): void {
            $table->id();
            $table->string('user_id');
            $table->string('dress_id');
            $table->string('dress_title');
            $table->string('image_url');
            $table->string('kind');
            $table->decimal('total', 10, 2);
            $table->string('status');
            $table->timestamp('rental_start')->nullable();
            $table->timestamp('rental_end')->nullable();
            $table->timestamp('placed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
