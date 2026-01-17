<?php

namespace App\Actions\Tickets;

use App\Models\Ticket;
use App\Models\Customer;
use App\Enums\TicketStatus;
use Illuminate\Support\Facades\DB;

class CreateTicketAction
{
    public function execute(array $data): Ticket
    {
        return DB::transaction(function () use ($data) {
            $customer = Customer::updateOrCreate(
                [
                    'email' => $data['customer_email'],
                ],
                [
                    'name' => $data['customer_name'],
                    'phone' => $data['customer_phone'],
                ]
            );
            
            $ticket = Ticket::create([
                'customer_id' => $customer->id,
                'subject' => $data['subject'],
                'status' => TicketStatus::NEW,
                'message' => $data['message'],
            ]);

            return $ticket;
        });
    }
}
