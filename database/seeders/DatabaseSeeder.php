<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'phone' =>'039459'.rand(1000,9999),
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('123456')
        ]);
        $arr = config('data.role');
         for($i= 1; $i <10 ; $i++){
             $role = array_rand($arr,1);

             \App\Models\User::create([
                 'name' => 'Test User'.$i,
                 'email' => 'test'.rand(1,1000000).'@example.com',
                 'phone' =>'039459'.rand(1000,9999),
                 'username' => 'test_'.rand(1,10000000),
                 'role' => $role,
                 'password' => Hash::make('123456')
             ]);
         }
        for($i= 1; $i <10 ; $i++){
            \App\Models\Customer::create([
                'name' => 'Test Customer '. $i,
                'email' => 'test'.rand(1,1000000).'@example.com',
                'phone' =>'039459'.rand(1000,9999),
            ]);
        }
    }
}
