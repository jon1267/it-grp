<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Services\Ticket\TicketCreationService;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    public function store(StoreTicketRequest $request, TicketCreationService $service): JsonResponse
    {
        $ticket = $service->create($request->validated());

        return response()->json([
            'message' => 'Заявка успешно создана.',
            'data' => new TicketResource($ticket),
        ], 201);
    }
}
