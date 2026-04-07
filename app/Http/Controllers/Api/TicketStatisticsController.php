<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Ticket\TicketStatisticsService;
use Illuminate\Http\JsonResponse;

class TicketStatisticsController extends Controller
{
    public function index(TicketStatisticsService $service): JsonResponse
    {
        return response()->json([
            'data' => $service->get(),
        ]);
    }
}
