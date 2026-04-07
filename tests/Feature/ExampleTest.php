<?php

namespace Tests\Feature;

use App\Enums\TicketStatus;
use App\Models\Customer;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_api_ticket_created(): void
    {
    
        Storage::fake('public');

        $file = UploadedFile::fake()->create('test.pdf', 100);

        $response = $this->postJson('/api/tickets', [
            'name' => 'John Doe',
            'phone' => '+14503217617',
            'email' => 'john@example.com',
            'title' => 'Need help',
            'description' => 'Some description',
            'files' => [$file],
        ]);

        $response->assertCreated()
            ->assertJsonPath('message', 'Заявка успешно создана.');

        $this->assertDatabaseCount('tickets', 1);
    }

    public function test_for_daily_limit(): void
    {
        $customer = Customer::factory()->create([
            'email' => 'john@example.com',
            'phone' => '+79990000000',
        ]);

        Ticket::factory()->create([
            'customer_id' => $customer->id,
            'created_at' => now(),
        ]);

        $response = $this->postJson('/api/tickets', [
            'name' => 'John Doe',
            'phone' => '+79990000000',
            'email' => 'john@example.com',
            'title' => 'Second request',
            'description' => 'Should fail',
        ]);

        $response->assertStatus(422);
    }

    public function test_for_statistics_api_rote_is_worked(): void
    {
        Ticket::factory()->count(3)->create([
            'created_at' => now(),
        ]);

        $response = $this->getJson('/api/tickets/statistics');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'today',
                    'week',
                    'month',
                    'by_status',
                ],
            ]);        
    }

}
