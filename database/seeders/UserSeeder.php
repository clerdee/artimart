<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\User;
use App\Models\Customer;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i = 0; $i < 25; $i++) {
            $fname = $faker->firstName();
            $lname = $faker->lastName();
            $user = new User();
            $user->name = $fname . ' ' . $lname;
            $user->email = strtolower($fname . '.' . $lname . '@gmail.com'); 
            $user->password = bcrypt('password');
            $user->save();
        
            $towns = [
                'Taguig' => 'Bonifacio Global City, Taguig',
                'Makati' => 'Ayala Avenue, Makati',
                'Las Pinas' => 'Alabang-Zapote Road, Las Pinas',
                'Pasay' => 'Ninoy Aquino International Airport, Pasay',
                'Muntinlupa' => 'Alabang, Muntinlupa',
                'Pateros' => 'Sta. Ana, Pateros',
            ];
        
            $town = $faker->randomElement(array_keys($towns));
            $addressline = $towns[$town];

            $phone = $faker->phoneNumber;   
            $phone = $faker->numerify('09#########');

            $customer = new Customer();
            $customer->title = $faker->randomElement(['Ms.', 'Mr.', 'Mrs.']);
            $customer->fname = $fname;
            $customer->lname = $lname;
            $customer->addressline = $addressline; 
            $customer->town = $town; 
            $customer->phone = $phone;
            $customer->user_id = $user->id;
            $customer->save();
        }
    }
}