<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 30; $i++) {
            Item::create([
                'description' => $faker->realText($maxNbChars = 10, $indexSize = 2),
                'price' => $faker->randomFloat(2, 0, 7),
                'image' => $faker->imageUrl($width = 640, $height = 480)
            ]);
        }
    }
}
