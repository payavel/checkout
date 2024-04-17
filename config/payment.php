<?php

return [

    'name' => 'Checkout',

    /*
    |--------------------------------------------------------------------------
    | Checkout Test Mode
    |--------------------------------------------------------------------------
    |
    | When set to true, the provider & account will be shared with the fake payment
    | request so you can mock your responses as you wish. This is very useful for
    | local & testing environments where a sandbox is limited or non-existent.
    |
    */
    'test_mode' => env('PAYMENT_TEST_MODE', false),

    /*
    |--------------------------------------------------------------------------
    | Checkout Testing
    |--------------------------------------------------------------------------
    |
    | This option allows you to define the location of the fake payment
    | request & response classes you would like to leverage when test_mode
    | is set to true. Also, feel free to add any other settings here.
    |
    */
    'test_gateway' => \App\Services\Payment\FakePaymentRequest::class,

];
