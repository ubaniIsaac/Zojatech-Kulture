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
        Schema::create('beats', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('imageUrl');
            $table->string('fileUrl');
            $table->integer('price');
            $table->string('genre');
            $table->string('duration');
            $table->integer('size');
            $table->string('type');
            $table->integer('total_sales')->default(0);
            $table->integer('play_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->integer('like_count')->default(0);
            $table->integer('download_count')->default(0);
            $table->timestamps();

            $table->foreignUlid('genre_id')->constrained('genres')->onDelete('cascade');
            $table->foreignUlid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUlid('producer_id')->constrained('producers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beats');
    }
};
