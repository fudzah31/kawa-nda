<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
           // panggil AdminSeeder
    $this->call(AdminSeeder::class);
     $this->call(PnsSeeder::class);
     $this->call(PppkSeeder::class);
    }
}
