<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class DayraController extends Controller
{
    public function getToken()
    {
        $url = 'https://api.testdayra.com/v1/partners/oauth/token';
        $client_id = '9b73cc33-fe67-4da5-9ebd-8a0edededcc9';
        $client_secret = 'XOGbXgsi3qjQovJU3SkPu2UQ2u1dGWJfaENY3Qog';

        $data = [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            // Handle error
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        $body = json_decode($response, true);
        return $body['access_token'] ?? null;
    }

    public function listUser() : object {
        $url = 'https://api.testdayra.com/v1/clients';
        $token = 'Bearer '. $this->getToken();
    
        // Initialize cURL session
        $ch = curl_init();
    
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: ' . $token,
            'Accept: application/json'
        ]);
    
        // Execute cURL request
        $response = curl_exec($ch);
    
        // Check for errors
        if ($response === false) {
            return response()->json(['error' => curl_error($ch)], 500);
        }
    
        // Close cURL session
        curl_close($ch);
    
        // Decode the response
        $users = json_decode($response, true);
        $data = $users['data']['payload']['data'];
        return view('Admin._dayra.users', compact('data'));
    }

    public function userDetails($uuid) : object {
        // $uuid = '337cb40e-0c7c-11ef-8d5c-b98dd33e4694';
        $url = 'https://api.testdayra.com/v1/clients/' . $uuid;
        $token = 'Bearer '. $this->getToken();
    
        // Initialize cURL session
        $ch = curl_init();
    
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: ' . $token,
            'Accept: application/json'
        ]);
    
        // Execute cURL request
        $response = curl_exec($ch);
    
        // Check for errors
        if ($response === false) {
            return response()->json(['error' => curl_error($ch)], 500);
        }
    
        // Close cURL session
        curl_close($ch);
    
        // Decode the response
        $user = json_decode($response, true);
        // dd($user);
        $data = $user['data']['payload'];
        return view('Admin._dayra.view', compact('data'));
    }

    public function userLimitDetails($uuid)
    {
        // Prepare the API URL
        $url = "https://api.testdayra.com/v1/clients/{$uuid}/loans/max-limit/inventory-finance";

        // Bearer token
        $token = 'Bearer '. $this->getToken();

        // Query parameters
        $queryParams = http_build_query([
            'p_uuid' => '46c09b02-d70c-11ee-a36f-ef27b0f5134c',
            'lp_uuid' => '334cc252-0071-413a-8f97-1ef897b20f0f',
            'with_ctc' => 'false',
        ]);

        // Complete URL with query parameters
        $url .= '?' . $queryParams;

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: ' . $token,
            'Accept: application/json',
            'x-c-uuid: ' . $uuid,
            'x-p-uuid: 46c09b02-d70c-11ee-a36f-ef27b0f5134c',
        ]);

        // Execute cURL request
        $response = curl_exec($ch);
        // Check for errors
        if ($response === false) {
            return response()->json(['error' => curl_error($ch)], 500);
        }

        // Close cURL session
        curl_close($ch);

        // Decode the response
        $user = json_decode($response, true);

        // Check for JSON decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON response'], 500);
        }

        // Handle the case where the response structure is not as expected
        if (!isset($user['data']['payload'])) {
            return response()->json(['error' => 'Invalid API response structure', 'response' => $user], 500);
        }

        $data = $user['data']['payload'];

        // Return the view with the data
        return view('Admin._dayra.user-limit', compact('data' , 'uuid'));
    }

    public function userInventoryFinance($uuid , Request $request)
    {
        $min = $request->input('min')/100;
        $max = $request->input('max')/100;
        $amount = $request->input('amount');

        // Ensure the amount is between min and max
        if ($amount < $min || $amount > $max) {
                return redirect()->back()->withErrors(['amount' => 'The amount must be between the minimum and maximum limits , Please Try Again.']);
        }
        
        $amount = $request->input('amount') *100;
        // Prepare the API URL
        $url = "https://api.testdayra.com/v1/clients/{$uuid}/loans/max-limit/inventory-finance";

        // Bearer token
        $token = 'Bearer '. $this->getToken();

        // Query parameters
        $queryParams = http_build_query([
            'p_uuid' => '46c09b02-d70c-11ee-a36f-ef27b0f5134c',
            'lp_uuid' => '334cc252-0071-413a-8f97-1ef897b20f0f',
            'with_ctc' => 'true',
            'total_amount' => $amount
        ]);

        // Complete URL with query parameters
        $url .= '?' . $queryParams;

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: ' . $token,
            'Accept: application/json',
            'x-c-uuid: ' . $uuid,
            'x-p-uuid: 46c09b02-d70c-11ee-a36f-ef27b0f5134c',
        ]);

        // Execute cURL request
        $response = curl_exec($ch);
        // Check for errors
        if ($response === false) {
            return response()->json(['error' => curl_error($ch)], 500);
        }

        // Close cURL session
        curl_close($ch);

        // Decode the response
        $user = json_decode($response, true);

        // Check for JSON decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON response'], 500);
        }

        // Handle the case where the response structure is not as expected
        if (!isset($user['data']['payload'])) {
            return response()->json(['error' => 'Invalid API response structure', 'response' => $user], 500);
        }

        $data = $user['data']['payload'];

        // Return the view with the data
        return view('Admin._dayra.user-inventory-limit', compact('data' , 'uuid'));
    }

    public function getLoanOptions(Request $request , $uuid)
    {
        $min = $request->input('min')/100;
        $max = $request->input('max')/100;
        $amount = $request->input('amount');

        // Ensure the amount is between min and max
        if ($amount < $min || $amount > $max) {
                return redirect()->back()->withErrors(['amount' => 'The amount must be between the minimum and maximum limits , Please Try Again.']);
        }
        $baseUrl = 'https://api.testdayra.com/v1/clients/loans/calculations/inventory-finance';
        $token = 'Bearer '. $this->getToken();
        $clientUuid = $uuid;
        $loanAmount = $request->input('amount') * 100;
        $loanProfileUuid =  '334cc252-0071-413a-8f97-1ef897b20f0f';

        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'x-c-uuid' => $uuid,
            ],
        ]);

        try {
            $response = $client->request('GET', $baseUrl, [
                'query' => [
                    'amount' => $loanAmount,
                    'lp_uuid' => '334cc252-0071-413a-8f97-1ef897b20f0f',
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $data = $response->getBody()->getContents();
            $data = json_decode($data);

            return view('Admin._dayra.loan-options', compact('data' , 'uuid'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function RequestLoan(Request $request , $uuid)
    {
        // dd($request);
        $option = $request['options'][$request['option_number']];
        $option = json_decode($option);
        $url = 'https://api.testdayra.com/v1/setup/clients/'. $uuid .'/loans/inventory-finance';
        $token = $this->getToken();
        $payload = [
            "payload" => [
                "total_amount" => $option->principal,
                "lp_uuid" => '334cc252-0071-413a-8f97-1ef897b20f0f',
                "requested_amount" => $option->principal,
                "number_of_periods" => $option->installments_count
            ]
        ];
        
        $ch = curl_init($url);
        $token = 'Bearer '. $token;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'x-c-uuid: 337cb40e-0c7c-11ef-8d5c-b98dd33e4694',
            'Authorization:'.$token ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        }
        
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($statusCode == 200) {
            return view('Admin._dayra.success');
        } else {
            return redirect()->route('dayra.users')->with(['error' =>  curl_error($ch)]);
        }
    }

}
