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
        Schema::create('favourites', function (Blueprint $table) {
            $table->foreignUlid('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignUlid('beat_id')->references('id')->on('beats')->onDelete('cascade');
            $table->unique(['user_id', 'beat_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
