<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Http\Resources\Manager\ManagerTicketResource;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ManagerTicketController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $tickets = Ticket::with('customer');

        if ($request->filled('status')) {
            $tickets->where('status', $request->query('status'));
        }

        if ($request->filled('phone')) {
            $tickets->whereHas('customer', function ($query) use ($request) {
                $query->where('phone', 'like', '%'.$request->query('phone').'%');
            });
        }

        $tickets = $tickets
            ->latest()
            ->paginate(15);

        return ManagerTicketResource::collection($tickets)->response();
    }
}
