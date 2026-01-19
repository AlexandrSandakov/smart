<?php

namespace Database\Seeders;

use App\Enums\TicketStatus;
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

        Ticket::create([
            'subject' => 'Sample Ticket Subject',
            'message' => 'This is a sample ticket message.',
            'customer_id' => $customer->id,
            'manager_id' => $manager->id,
            'status' => TicketStatus::NEW,
            'answered_at' => null,
        ]);

        Ticket::create([
            'subject' => 'Another Ticket Subject',
            'message' => 'This is another sample ticket message.',
            'customer_id' => $customer->id,
            'manager_id' => $manager->id,
            'status' => TicketStatus::CLOSED,
            'answered_at' => now(),
        ]);
    }
}
