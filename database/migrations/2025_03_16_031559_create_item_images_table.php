<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('item_images', function (Blueprint $table) {
            $table->id('itemimg_id');
            $table->integer('item_id');
            $table->string('image_path');
            $table->timestamps();
    
            $table->foreign('item_id')
                  ->references('item_id')
                  ->on('item')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_images');
    }
};
