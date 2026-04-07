<?php

namespace App\Services\Ticket;

use App\Models\Ticket;
use Carbon\Carbon;

class TicketStatisticsService
{
    public function get(): array
    {
        return [
            'today' => Ticket::query()->createdBetween(now()->startOfDay(), now()->endOfDay())->count(),
            'week' => Ticket::query()->createdBetween(now()->startOfWeek(), now()->endOfWeek())->count(),
            'month' => Ticket::query()->createdBetween(now()->startOfMonth(), now()->endOfMonth())->count(),
            'by_status' => [
                'new' => Ticket::query()->where('status', 'new')->count(),
                'processing' => Ticket::query()->where('status', 'processing')->count(),
                'closed' => Ticket::query()->where('status', 'closed')->count(),
            ],
        ];
    }
}

