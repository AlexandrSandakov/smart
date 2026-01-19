<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Ticket;

class ManagerTicketController extends Controller
{
    /**
     * Display a listing of the tickets.
     */
    public function index()
    {
        $tickets = Ticket::query()->with('customer')->latest()->paginate(15);

        return view('manager.tickets.index', compact('tickets'));
    }
}
