<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enum\DonationType;
use App\Enum\PaymentMethod;
use App\Models\Donor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $husniDonation = Donor::create([
            'name' => 'Husni Robani',
            'house_number' => 'B12',
            'total_muzaki' => 4,
            'email' => 'husnir2005@gmail.com',
        ]);

        $husniDonation->transactions()->create([
            'donation_type' => DonationType::Fitrah,
            'payment_method' => PaymentMethod::Cash,
            'total_money' => 50000000.00,
            'total_good' => null,
        ]);

    }
}
