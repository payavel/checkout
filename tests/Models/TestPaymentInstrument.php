<?php

namespace Payavel\Checkout\Tests\Models;

use Payavel\Checkout\Models\PaymentInstrument;

class TestPaymentInstrument extends PaymentInstrument
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_instruments';

    /**
     * Check if model is overridden for testing purposes.
     */
    public bool $overridden = true;
}
