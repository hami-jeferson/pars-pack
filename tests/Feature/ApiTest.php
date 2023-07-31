<?php

namespace Tests\Feature;

use App\Models\App;
use App\Models\ExpiredSubscription;
use App\Models\Platform;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase; // Optional if you want to reset the database for each test

    /**
     * Test the /expired-subscriptions API endpoint.
     *
     * @return void
     */
    public function testExpiredSubscriptionsEndpointEmptyData()
    {
        // Perform a GET request to the /expired-subscriptions endpoint
        $response = $this->get('/api/expired-subscriptions');

        // Assert that the response has a successful status code (e.g., 200)
        $response->assertStatus(200);

        // Assert that the JSON response contains the 'status' key with the value 'false'
        $response->assertJson([
            'success' => false,
        ]);

        // Assert that the JSON response contains the 'message' key
        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function testExpiredSubscriptionsEndpointWithData()
    {
        Artisan::call('db:seed');
        ExpiredSubscription::factory()->create();

        // Perform a GET request to the /expired-subscriptions endpoint
        $response = $this->get('/api/expired-subscriptions');

        // Assert that the response has a successful status code (e.g., 200)
        $response->assertStatus(200);

        // Get the JSON data from the response
        $responseData = $response->json();

        // Assert that the response contains the 'success' key with the value 'true'
        $this->assertTrue($responseData['success']);

        // Assert that the response contains the 'data' key
        $this->assertArrayHasKey('data', $responseData);

        // Get the 'data' array from the response
        $data = $responseData['data'];

        // Assert that the 'data' array contains the 'sync_date' key
        $this->assertArrayHasKey('sync_date', $data);

        // Assert that the 'data' array contains the 'total_expired_count' key
        $this->assertArrayHasKey('total_expired_count', $data);

        // Assert that the 'total_expired_count' key is an integer
        $this->assertIsInt($data['total_expired_count']);

        // Assert that the 'data' array contains the 'details' key
        $this->assertArrayHasKey('details', $data);

        // Get the 'details' array from the data
        $details = $data['details'];

        // Iterate through the 'details' array and check the data types
        foreach ($details as $detail) {

            // Assert that the 'detail' array contains the 'app_name' key
            $this->assertArrayHasKey('app_name', $detail);

            // Assert that the 'detail' array contains the 'expired_count' key
            $this->assertArrayHasKey('expired_count', $detail);

            // Assert that the 'app_name' key is a string
            $this->assertIsString($detail['app_name']);

            // Assert that the 'expired_count' key is an integer
            $this->assertIsInt($detail['expired_count']);
        }


    }
}
