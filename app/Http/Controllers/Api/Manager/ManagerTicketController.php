<?php

namespace App\Http\Controllers\Api\Manager;

use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;

class ManagerTicketController extends Controller
{
    public function index(): JsonResponse
    {
        $tickets = Ticket::query()->with('customer')->latest()->paginate(15);
        
        return TicketResource::collection($tickets)->response();
    }
}
