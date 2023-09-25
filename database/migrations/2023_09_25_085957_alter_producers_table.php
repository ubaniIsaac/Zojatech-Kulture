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
        Schema::table('producers', function (Blueprint $table) {
            $table->string('subscription_status');
            $table->string('subscription_plan');
            $table->foreignUlid('subscription_id')->nullable()->references('id')->on('subscriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumn('subscription_id');
        Schema::dropColumn('subscription_plan');
        Schema::dropColumn('subscription_status');
    }
};
