<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::create([
            'name' => 'Test Customer',
            'email' => 'test@test.com',
            'password' => Hash::make('secret123'),
        ]);
    }
}
