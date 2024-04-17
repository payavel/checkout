<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Payment Test Mode
    |--------------------------------------------------------------------------
    |
    | When set to true, it will pass the provider & account into the testing
    | gateway so you can mock your requests as you wish. This is very
    | useful when you are running tests in a CI/CD environment.
    |
    */
    'test_mode' => false,


    /*
    |--------------------------------------------------------------------------
    | Payment Mocking
    |--------------------------------------------------------------------------
    |
    | Here you can override the location and/or class name of your fake payment
    | request & response classes. Also, feel free to add any additional config
    | that may assist you in defining your mocked checkout responses.
    |
    */
    'mocking' => [
        'request_class' => \App\Services\Payment\FakePaymentRequest::class,
        'response_class' => \App\Services\Payment\FakePaymentResponse::class,
    ],

];
