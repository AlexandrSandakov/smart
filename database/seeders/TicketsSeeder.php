<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class TicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = Customer::inRandomOrder()->first();

        if (! $customer) {

            throw new RuntimeException('No customers found. Please seed customers before seeding tickets.');
        }

        $manager = User::role('manager')->first();

        if (! $manager) {

            throw new RuntimeException('No manager user found. Please seed a manager user before seeding tickets.');
        }

        Ticket::factory()->count(5)->create();

        Ticket::factory()->count(5)->inProgress($manager)->create();

        Ticket::factory()->count(5)->closed($manager)->create();
    }
}
