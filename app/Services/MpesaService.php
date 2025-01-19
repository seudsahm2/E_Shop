<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    private $client;
    protected $baseUrl;
    protected $consumerKey;
    protected $consumerSecret;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
        $this->baseUrl = config('mpesa.base_url'); // Fetch from config
        $this->consumerKey = config('mpesa.consumer_key');
        $this->consumerSecret = config('mpesa.consumer_secret');
    }

    public function getAccessToken()
    {
        try {
            $url = $this->baseUrl . '/v1/generate?grant_type=client_credentials'; // Build URL

            $response = $this->client->get($url, [
                'auth' => [$this->consumerKey, $this->consumerSecret], // Use credentials from config
            ]);

            $body = json_decode($response->getBody(), true);

            if (isset($body['access_token'])) {
                return $body['access_token'];
            } else {
                throw new \Exception('Failed to retrieve access token');
            }
        } catch (\Exception $e) {
            Log::error('Access Token Error:', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function registerUrls()
    {
        $accessToken = $this->getAccessToken();
        $url = $this->baseUrl . '/v1/c2b-register-url/register'; // Build URL

        $response = $this->client->post('/c2b-register-url/register', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
            'json' => [
                'ShortCode' => config('mpesa.shortcode'),
                'ResponseType' => 'Completed',
                'CommandID' => 'RegisterURL',
                'ConfirmationURL' => config('mpesa.confirmation_url'),
                'ValidationURL' => config('mpesa.validation_url'),
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
    public function simulatePayment($amount, $msisdn, $billRefNumber, $shortCode)
    {
        $accessToken = $this->getAccessToken();
        $url = $this->baseUrl . '/mpesa/b2c/simulatetransaction/v1/request';
        $data = [
            'CommandID' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'Msisdn' => $msisdn,
            'BillRefNumber' => $billRefNumber,
            'ShortCode' => $shortCode,
        ];

        try {
            // Build full URL

            $response = $this->client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);

            $responseBody = json_decode($response->getBody(), true);
            Log::info('M-PESA Simulation Response:', $responseBody);

            return $responseBody;
        } catch (\Exception $e) {
            Log::error('M-PESA Simulation Error:', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
