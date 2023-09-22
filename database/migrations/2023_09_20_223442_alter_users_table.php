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

        if (!Schema::hasColumn('users', 'subcription_plan')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('subcription_plan');
                $table->dropColumn('subcription_status');
            });
        }


        Schema::table('users', function (Blueprint $table) {
            $table->string('device_id')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('subscription_plan')->default('Free Plan');
            $table->string('subscription_status')->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('device_id');
            $table->dropColumn('referral_code');
        });
    }
};
