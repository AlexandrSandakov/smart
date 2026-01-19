<?php

namespace App\Actions\Tickets;

use App\Enums\TicketStatus;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class CreateTicketAction
{
    public function execute(array $data, array $files = []): Ticket
    {
        return DB::transaction(function () use ($data, $files) {
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

            if (! empty($files)) {
                foreach ($files as $file) {
                    $ticket->addMedia($file)
                        ->toMediaCollection('attachments');
                }
            }

            $ticket->load('media');

            return $ticket;
        });
    }
}
