<?php

namespace Database\Factories;

use App\Enums\TicketStatus;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(TicketStatus::values());

        return [
            'customer_id' => Customer::factory(),
            'title' => fake()->sentence(6),
            'description' => fake()->paragraph(),
            'status' => $status,
            'answered_at' =>  in_array($status, [TicketStatus::Processing->value, TicketStatus::Closed->value], true)
                ? fake()->optional()->dateTime()
                : null,
        ];
    }
}
