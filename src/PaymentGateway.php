<?php

namespace Payavel\Checkout;

use Payavel\Orchestration\Service;

class PaymentGateway extends Service
{
    public function __construct()
    {
        parent::__construct('checkout');
    }
}
