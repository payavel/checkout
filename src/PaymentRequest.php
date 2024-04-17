<?php

namespace Payavel\Checkout;

use Payavel\Checkout\Contracts\PaymentRequestor;
use Payavel\Checkout\Traits\PaymentRequests;
use Payavel\Orchestration\ServiceRequest;

abstract class PaymentRequest extends ServiceRequest implements PaymentRequestor
{
    use PaymentRequests;

    /**
     * The service response class.
     *
     * @var \Payavel\Orchestration\ServiceResponse
     */
    protected $serviceResponse = PaymentResponse::class;
}
