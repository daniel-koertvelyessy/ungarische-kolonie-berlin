<?php

namespace Database\Seeders;

use App\Actions\Accounting\CreateBookingAccount;
use App\Enums\BookingAccountType;
use App\Enums\Gender;
use App\Enums\MemberType;
use App\Models\Event;
use App\Models\Member;
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

        Member::factory()->create([
            'entered_at' => date('Y-m-d H:i:s'),
            'is_deducted' => false,
            'birth_date' => '1974-01-07',
            'name' => 'Körtvélyessy',
            'first_name' => 'Daniel',
            'email' => 'daniel@thermo-control.com',
            'phone' => '+493040586940',
            'mobile' => '+491735779408',
            'address' => 'Grünspechtweg 19',
            'city' => 'Berlin',
            'user_id' => 1,
            'type' => MemberType::MD->value
        ]);


        CreateBookingAccount::create([
           'type' => BookingAccountType::Expenses->value,
            'number' => '2701',
            'label' => 'Büromaterial',
        ]);



        if (app()->environment() !== 'production') {
            Member::factory(30)
                ->create();
            Event::factory(10)
                ->create();
        }


    }
}
