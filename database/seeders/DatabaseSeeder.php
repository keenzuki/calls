<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// use App\Models\Customers;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // \App\Models\User::factory(10)->create();

    //    Customers::factory()->count(1000)->create();

        \App\Models\User::factory()->create([
            'name' => 'Francis Nzuki',
            'email' => 'nzukifrancis20@gmail.com',
            'password' =>Hash::make('admin'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Franc Keen',
            'email' => 'ncifrasmnyc11@gmail.com',
            'password' =>Hash::make('admin'),
        ]);
    }
}
