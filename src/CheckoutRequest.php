<?php

namespace Payavel\Checkout;

use Payavel\Checkout\Contracts\CheckoutRequester;
use Payavel\Checkout\Traits\CheckoutRequests;
use Payavel\Orchestration\ServiceRequest;

abstract class CheckoutRequest extends ServiceRequest implements CheckoutRequester
{
    use CheckoutRequests;
}
