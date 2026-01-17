<?php

namespace App\Models;

use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'customer_id',
        'subject',
        'status',
        'message',
        'manager_id',
        'answered_at',
    ];

    protected $casts = [
        'status' => TicketStatus::class,
        'answered_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
