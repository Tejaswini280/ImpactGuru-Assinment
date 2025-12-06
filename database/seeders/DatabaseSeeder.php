<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@impactguru.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // NOTE: Staff users are created dynamically via registration (many staff accounts).
        // Only seed a fixed admin account here so admin credentials remain controlled.

        // Create sample customers
        $customers = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '+1234567890',
                'address' => '123 Main St, New York, NY 10001',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '+1234567891',
                'address' => '456 Oak Ave, Los Angeles, CA 90001',
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'phone' => '+1234567892',
                'address' => '789 Pine Rd, Chicago, IL 60601',
            ],
            [
                'name' => 'Alice Williams',
                'email' => 'alice@example.com',
                'phone' => '+1234567893',
                'address' => '321 Elm St, Houston, TX 77001',
            ],
            [
                'name' => 'Charlie Brown',
                'email' => 'charlie@example.com',
                'phone' => '+1234567894',
                'address' => '654 Maple Dr, Phoenix, AZ 85001',
            ],
        ];

        foreach ($customers as $customerData) {
            $customer = Customer::create($customerData);

            // Create 2-4 orders for each customer
            $orderCount = rand(2, 4);
            for ($i = 0; $i < $orderCount; $i++) {
                Order::create([
                    'customer_id' => $customer->id,
                    'order_number' => Order::generateOrderNumber(),
                    'amount' => rand(100, 5000),
                    'status' => ['pending', 'completed', 'cancelled'][rand(0, 2)],
                    'order_date' => now()->subDays(rand(1, 30)),
                ]);
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin Login: admin@impactguru.com / password');
        $this->command->info('Staff accounts are created via public registration (no fixed staff credential).');
    }
}