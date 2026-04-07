<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function index(Request $request): View
    {
        $tickets = Ticket::query()
            ->with('customer')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('email'), fn ($query) => $query->whereHas('customer', fn ($q) => $q->where('email', 'like', '%' . $request->string('email') . '%')))
            ->when($request->filled('phone'), fn ($query) => $query->whereHas('customer', fn ($q) => $q->where('phone', 'like', '%' . $request->string('phone') . '%')))
            ->when($request->filled('from'), fn ($query) => $query->whereDate('created_at', '>=', $request->date('from')))
            ->when($request->filled('to'), fn ($query) => $query->whereDate('created_at', '<=', $request->date('to')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.tickets.index', ['tickets' => $tickets]);
    }

    public function show(Ticket $ticket): View
    {
        $ticket->load(['customer', 'media']);

        return view('admin.tickets.show', ['ticket' => $ticket]);
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', TicketStatus::values())],
        ]);

        $ticket->update([
            'status' => $data['status'],
            'answered_at' => $data['status'] === TicketStatus::Closed->value ? now() : $ticket->answered_at,
        ]);

        return back()->with('success', 'Статус заявки обновлён.');
    }
}
