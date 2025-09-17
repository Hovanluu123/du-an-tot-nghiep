<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        if (!User::where('email', 'admin@fitzone.com')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@fitzone.com',
                'phone' => '0123456789',
                'password' => Hash::make('admin123456'),
                'address' => 'FitZone Headquarters',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }

        // Update existing user to admin if needed (based on your current data)
        $existingUser = User::where('email', 'vudevweb@gmail.com')->first();
        if ($existingUser && $existingUser->role !== 'admin') {
            $existingUser->update(['role' => 'admin']);
        }
    }
}
