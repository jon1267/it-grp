<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\TicketStatus;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::query()->get();

        foreach ($customers as $customer) {
            Ticket::factory()
                ->count(rand(1, 3))
                ->create([
                    'customer_id' => $customer->id,
                    'status' => fake()->randomElement(TicketStatus::values()),
                ]);
        }
    }
}
