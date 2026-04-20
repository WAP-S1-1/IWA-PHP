<?php

namespace Database\Seeders;

use App\Models\Customer\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::create([
            'name' => 'Test Customer',
            'email' => 'test@test.com',
            'password' => Hash::make('secret123'),
            'company_id' => 10
        ]);
    }
}
