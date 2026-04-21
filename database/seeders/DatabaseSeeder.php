<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
{
    \App\Models\User::create([
        'username' => 'owner_bakery',
        'email' => 'ownerbakery@gmail.com',
        'password' => bcrypt('owner123'), 
        'role' => 'owner',
    ]);
}
}
