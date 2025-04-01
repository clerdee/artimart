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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('review_id');
            $table->integer('orderinfo_id');
            $table->integer('customer_id');
            $table->integer('item_id');
            $table->tinyInteger('rating')->check('rating >= 1 AND rating <= 5');
            $table->text('review_text')->nullable();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('orderinfo_id')->references('orderinfo_id')->on('orderinfo')->onDelete('cascade');
            $table->foreign('customer_id')->references('customer_id')->on('customer')->onDelete('cascade');
            $table->foreign('item_id')->references('item_id')->on('item')->onDelete('cascade');
            $table->unique(['customer_id', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
