<?php

namespace Payavel\Checkout\Tests\Models;

use Payavel\Checkout\Models\PaymentRail;

class TestPaymentRail extends PaymentRail
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_rails';

    /**
     * Check if model is overridden for testing purposes.
     *
     * @var bool
     */
    public bool $overridden = true;
}
