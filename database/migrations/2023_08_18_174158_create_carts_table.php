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
        //
        Schema::create('carts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->json('items');
            $table->double('total_price')->nullable();
            $table->timestamps();

            $table->foreignUlid('beat_id')->constrained('beats')->cascadeOnDelete();
            $table->foreignUlid('user_id')->constrained('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('carts');
    }
};
