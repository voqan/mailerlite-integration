<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MailerLiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // If you have any setup needed for tests, put it here.
    }

    /** @test */
    public function it_validates_and_saves_api_key()
    {
        $response = $this->post('/api-keys', ['api_key' => 'MAILERLITE_API_KEY']);

        $response->assertStatus(200);
        $this->assertDatabaseHas('api_keys', ['api_key' => 'MAILERLITE_API_KEY']);
    }

    /** @test */
    public function it_does_not_save_invalid_api_key()
    {
        $response = $this->post('/api-keys', ['api_key' => 'invalid_api_key']);

        $response->assertStatus(400);
        $this->assertDatabaseMissing('api_keys', ['api_key' => 'invalid_api_key']);
    }

    /** @test */
    public function it_creates_a_new_subscriber()
    {
        // Save a valid API key to the database before testing subscriber creation
        DB::table('api_keys')->insert(['api_key' => 'MAILERLITE_API_KEY']);

        $subscriber_data = [
            'email' => 'test@example.com',
            'name' => 'John Doe',
            'country' => 'USA',
        ];

        $response = $this->post('/subscribers', $subscriber_data);

        $response->assertRedirect('/subscribers');
        $response->assertSessionHas('success', 'Subscriber created successfully.');
    }

    /** @test */
    public function it_updates_a_subscriber()
    {
        // Save a valid API key to the database before testing subscriber update
        DB::table('api_keys')->insert(['api_key' => 'MAILERLITE_API_KEY']);

        // Replace with a valid subscriber ID from your MailerLite account
        $subscriber_id = 'valid_subscriber_id';

        $subscriber_data = [
            'name' => 'Jane Doe',
            'country' => 'UK',
        ];

        $response = $this->put("/subscribers/{$subscriber_id}", $subscriber_data);

        $response->assertRedirect('/subscribers');
        $response->assertSessionHas('success', 'Subscriber updated successfully.');
    }

    /** @test */
    public function it_deletes_a_subscriber()
    {
        // Save a valid API key to the database before testing subscriber deletion
        DB::table('api_keys')->insert(['api_key' => 'MAILERLITE_API_KEY']);

        // Replace with a valid subscriber ID from your MailerLite account
        $subscriber_id = 'valid_subscriber_id';

        $response = $this->delete("/subscribers/{$subscriber_id}");

        $response->assertStatus(200);
    }
}

