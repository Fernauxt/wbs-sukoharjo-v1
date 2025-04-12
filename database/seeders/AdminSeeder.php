<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin-1',
            'email' => 'ferrum.416@gmail.com',
            'username' => 'adm-ferrum',
            'password' => Hash::make('ferrum416')
        ]);
    }
}
