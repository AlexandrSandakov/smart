<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManagerTicketFilterRequest;
use App\Models\Ticket;

class ManagerTicketController extends Controller
{
    /**
     * Display a listing of the tickets.
     */
    public function index(ManagerTicketFilterRequest $request)
    {
        $tickets = Ticket::query()
            ->with(['customer', 'manager'])
            ->filter($request->filters())
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('manager.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['customer', 'manager']);

        return view('manager.tickets.show', compact('ticket'));
    }
}
