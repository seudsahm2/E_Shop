<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;

class MpesaController extends Controller
{
    public $consumerKey;
    public $consumerSecret;
    public $baseUrl;
    public $apiKey;
    public $shortCode;
    public $confirmationUrl;
    public $validationUrl;
    public $ResponseType = "Completed";
    public $CommandID = "RegisterURL";
    public function __construct()
    {
        $this->consumerKey = config('mpesa.consumer_key');
        $this->consumerSecret = config('mpesa.consumer_secret');
        $this->baseUrl = config('mpesa.base_url');
        $this->apiKey = config('mpesa.api_key'); // Your API key from the config or .env
        $this->shortCode = config('mpesa.shortcode'); // Your ShortCode from config or .env
        $this->confirmationUrl = config('mpesa.confirmation_url'); // Your confirmation URL from .env
        $this->validationUrl = config('mpesa.validation_url'); // Your validation URL from .env

    }
    /**
     * Show the access token form.
     *
     * @return \Illuminate\View\View
     */
    public function showAccessTokenForm()
    {
        return view('mpesa.access-token');
    }

    /**
     * Generate M-Pesa Access Token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function generateAccessToken(Request $request)
    {
        // Get the M-Pesa credentials

        try {
            // Encode Consumer Key and Secret in Base64 format
            $credentials = base64_encode("{$this->consumerKey}:{$this->consumerSecret}");

            // Set the endpoint URL
            $url = $this->baseUrl . '/v1/token/generate?grant_type=client_credentials';

            // Send the GET request with the correct Authorization header and disable SSL verification
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $credentials, // Basic Auth header with Base64 encoded credentials
            ])
                ->withoutVerifying() // Disable SSL certificate verification
                ->get($url);

            // Log the full response for debugging
            Log::info('Access Token Response Status:', ['status_code' => $response->status()]);
            Log::info('Access Token Response Body:', ['body' => $response->body()]);

            // Check if the request was successful
            if ($response->successful()) {
                $responseBody = $response->json();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Access token generated successfully',
                    'data' => $responseBody,
                ], 200);
            } else {
                // Log additional information about the failed response
                Log::error('Error generating access token', [
                    'response_status' => $response->status(),
                    'response_body' => $response->body(),
                    'response_headers' => $response->headers(),
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to generate access token',
                    'data' => $response->json(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            // Log the exception details
            Log::error('Exception generating access token', ['error' => $e->getMessage()]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while generating access token',
                'details' => $e->getMessage(),
            ], 500);
        }
    }


    public function registerUrlForm()
    {
        // Show the form
        return view(
            'mpesa.register_url_form',
        );
    }

    public function registerUrl(Request $request)
    {
        // Get values from the form or the config

        // Validate the request
        $validated = $request->validate([
            'ShortCode' => 'required|string',
            'ResponseType' => 'required|string',
            'CommandID' => 'required|string',
            'ConfirmationURL' => 'required|url',
            'ValidationURL' => 'required|url',
        ]);

        // Set the API endpoint URL for URL registration
        $url = $this->baseUrl . '/v1/c2b-register-url/register' . urlencode($this->apiKey);

        // Prepare the payload
        $data = [
            "ShortCode" => $validated['ShortCode'] ?? $this->shortCode,
            "ResponseType" => $validated['ResponseType'] ?? 'Completed',
            "CommandID" => $validated['CommandID'] ?? 'RegisterURL',
            "ConfirmationURL" => $validated['ConfirmationURL'] ?? $this->confirmationUrl,
            "ValidationURL" => $validated['ValidationURL'] ?? $this->validationUrl,
        ];



        try {

            // Send the POST request to the M-PESA API
            $response = Http::post($url, $data);




            // Check if the request was successful
            if ($response->successful()) {
                // Return the result to the view
                return view('mpesa.register_url_response', [
                    'status' => 'success',
                    'message' => 'URL registration successful!',
                    'data' => $response->json(),
                ]);
            } else {
                // Handle the error response
                return view('mpesa.register_url_response', [
                    'status' => 'error',
                    'message' => 'Failed to register URL',
                    'data' => $response->json(),
                ]);
            }
        } catch (\Exception $e) {

            // Log and handle the error
            Log::error('Error registering URL with M-PESA API', ['error' => $e->getMessage()]);
            return view('mpesa.register_url_response', [
                'status' => 'error',
                'message' => 'An error occurred while registering the URL',
                'data' => $e->getMessage(),
            ]);
        }
    }
}
