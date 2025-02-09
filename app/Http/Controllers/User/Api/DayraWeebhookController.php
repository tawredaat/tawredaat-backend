<?php

namespace App\Http\Controllers\User\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DayraWeebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
    // Validate the request (optional but recommended)
        $this->validateWebhook($request);

        // Parse the JSON payload
        $payload = json_decode($request->getContent(), true);

        // Handle different event types
        switch ($payload['payload']['event_type']) {
            case 'client.onboarded':
                $this->handleClientOnboarded($payload);
                break;
            // Add more cases for other event types as needed
        }

        // Return a 2xx response
        return response()->json(['message' => 'Webhook received successfully'], 200);
    }

    protected function validateWebhook(Request $request)
    {
        // Implement your validation rules here
        // For example, you can validate the request's headers or signature
    }

    protected function handleClientOnboarded(array $payload)
    {
        // Extract data from the payload
        $eventUuid = $payload['payload']['event_uuid'];
        $clientUuid = $payload['payload']['data']['c_uuid'];
        $externalId = $payload['payload']['data']['external_id'];
        $tags = $payload['payload']['data']['tags'];

        // Process the client onboarded event
        // Implement your logic here, e.g., save the client details to your database
        // Example:
        // Client::create([
        //     'event_uuid' => $eventUuid,
        //     'client_uuid' => $clientUuid,
        //     'external_id' => $externalId,
        //     'tags' => json_encode($tags),
        // ]);
    }
}
