<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->withPersonalTeam()->create([
            'name' => 'Körtrvélyessy',
            'email' => 'daniel@thermo-control.com',
            'username' => 'Daniel',
            'first_name' => 'Daniel',
            'gender' => Gender::ma,
            'is_admin' => true,
            'password' => Hash::make('33 hkB47!!'),
        ]);
    }
}
