<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipping', function (Blueprint $table) {
            $table->id('shipping_id'); 
            $table->string('region'); // Shipping region
            $table->decimal('rate', 8, 2);
            $table->timestamps();
        });

        DB::table('shipping')->insert([
            ['region' => 'Within Metro Manila', 'rate' => 50.00],
            ['region' => 'Luzon (Outside Metro Manila)', 'rate' => 70.00],
            ['region' => 'Visayas', 'rate' => 90.00],
            ['region' => 'Mindanao', 'rate' => 110.00],
            ['region' => 'Overseas', 'rate' => 200.00],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping');
    }
};
