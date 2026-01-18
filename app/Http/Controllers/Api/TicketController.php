<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Actions\Tickets\CreateTicketAction;
use App\Http\Resources\TicketResource;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    public function store(StoreTicketRequest $request, CreateTicketAction $createTicketAction): JsonResponse
    {
        $data = $request->validated();
        $files = $request->file('files', []);
        if ($files === null) {
            $files = [];
        } elseif (!is_array($files)) {
            $files = [$files];
        }
        $ticket = $createTicketAction->execute($data, $files);
        return (new TicketResource($ticket))
            ->response()
            ->setStatusCode(201);
    }
}
