<?php

namespace App\Http\Controllers\Api\Manager;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ManagerTicketStatsController extends Controller
{
    public function show(): JsonResponse
    {

        $now = now();

        $fromDay = $now->copy()->startOfDay();
        $fromWeek = $now->copy()->startOfWeek();
        $fromMonth = $now->copy()->startOfMonth();

        $data = [
            'day' => $this->counts($fromDay, $now),
            'week' => $this->counts($fromWeek, $now),
            'month' => $this->counts($fromMonth, $now),
        ];

        return response()->json($data);
    }

    private function counts(Carbon $from, Carbon $to): array
    {
        $rows = Ticket::query()
            ->createdBetween($from, $to)
            ->select('status', DB::raw('COUNT(*) as cnt'))
            ->groupBy('status')
            ->pluck('cnt', 'status');

        return [
            'total' => $rows->sum(),
            'new' => $rows->get(TicketStatus::NEW->value, 0),
            'in_progress' => $rows->get(TicketStatus::IN_PROGRESS->value, 0),
            'closed' => $rows->get(TicketStatus::CLOSED->value, 0),
        ];
    }
}
