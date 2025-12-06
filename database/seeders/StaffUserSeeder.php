<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disabled: staff accounts are public and created via the registration flow.
        $this->command->info('StaffUserSeeder disabled: staff are created by public registration.');
    }
}
