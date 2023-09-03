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

        Schema::table('artistes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropPrimary('user_id');
            $table->primary('id');
        });
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('artistes', function (Blueprint $table) {
        //     $table->dropColumn('id');
        //     $table->dropColumn('user_id')->primary()->uniqid();
          

        // });
    }
};
