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
        Schema::table('orderinfo', function (Blueprint $table) {
            $table->unsignedBigInteger('shipping_id')->after('date_shipped');  
            $table->foreign('shipping_id')->references('shipping_id')->on('shipping')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orderinfo', function (Blueprint $table) {
            $table->dropForeign(['shipping_id']);  
            $table->dropColumn('shipping_id');
        });
    }
};
