<?php

namespace Payavel\Checkout\Tests\Models;

use Payavel\Checkout\Models\Payment;

class TestPayment extends Payment
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * Check if model is overridden for testing purposes.
     *
     * @var bool
     */
    public bool $overridden = true;
}
