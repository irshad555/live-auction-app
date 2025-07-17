<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class BidderUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = User::firstOrCreate(
            ['email' => 'bidder@example.com'],
            [
                'name' => 'Bidder',
                'password' => Hash::make('password123'),
            ]
        );

        $admin->assignRole('bidder');
    }
}
