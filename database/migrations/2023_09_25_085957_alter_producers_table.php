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
            $table->string('subscription_status')->nullable();
            $table->string('subscription_plan')->nullable();
            $table->foreignUlid('subscription_id')->nullable()->references('id')->on('subscriptions')->onDelete('cascade');
        });
    }

    /**
     *
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('producers', function (Blueprint $table) {
           $table->dropColumn('subscription_id');
           $table->dropColumn('subscription_plan');
           $table->dropColumn('subscription_status');
        });
    }
};
