<?php

return [
    'base_url' => env('MPESA_ENV', 'sandbox') === 'sandbox'
        ? 'https://apisandbox.safaricom.et'
        : 'https://api.safaricom.et',
    'shortcode' => env('MPESA_SHORTCODE'),
    'consumer_key' => env('MPESA_CONSUMER_KEY'),
    'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
    'api_key' => env('MPESA_API_KEY'),
    'confirmation_url' => env('MPESA_CONFIRMATION_URL'),
    'validation_url' => env('MPESA_VALIDATION_URL'),
    'timeout_url' => env('MPESA_TIMEOUT_URL'),
    'results_url' => env('MPESA_RESULT_URL'),
];
