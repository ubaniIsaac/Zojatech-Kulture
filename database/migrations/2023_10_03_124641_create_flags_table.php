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
        Schema::create('flags', function (Blueprint $table) {
            $table->ulid('id')->primary()->uniqid();
            $table->string('reason');
            $table->string('description');
            $table->string('status');
            $table->string('type');
            $table->string('approved_by')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('approved_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignUlid('beat_id')->references('id')->on('beats')->cascadeOnDelete();
            $table->foreignUlid('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignUlid('producer_id')->references('id')->on('producers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flags');
    }
};
