<?php

namespace App\Services\Ticket;

use App\Enums\TicketStatus;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TicketCreationService
{
    /**
     * @param array{
     *     name: string,
     *     phone: string,
     *     email: string,
     *     title: string,
     *     description?: string|null,
     *     files?: array<int, UploadedFile>
     * } $data
     */
    public function create(array $data): Ticket
    {
        return DB::transaction(function () use ($data) {
            $this->ensureDailyLimit($data['email'], $data['phone']);

            $customer = Customer::query()->firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                ]
            );

            $ticket = Ticket::query()->create([
                'customer_id' => $customer->id,
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'status' => TicketStatus::New,
                'answered_at' => null,
            ]);

            foreach ($data['files'] ?? [] as $file) {
                $ticket->addMedia($file)->toMediaCollection('attachments');
            }

            return $ticket->load(['customer', 'media']);
        });
    }

    private function ensureDailyLimit(string $email, string $phone): void
    {
        $exists = Ticket::query()
            ->whereHas('customer', function ($query) use ($email, $phone) {
                $query->where('email', $email)
                    ->orWhere('phone', $phone);
            })
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'email' => 'Можно отправить не более одной заявки в сутки с одного email или телефона.',
                'phone' => 'Можно отправить не более одной заявки в сутки с одного email или телефона.',
            ]);
        }
    }
}

