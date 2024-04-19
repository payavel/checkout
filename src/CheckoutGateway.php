<?php

namespace Payavel\Checkout;

use Payavel\Orchestration\Service;

class CheckoutGateway extends Service
{
    public function __construct()
    {
        parent::__construct('checkout');
    }
}
