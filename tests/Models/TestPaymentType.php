<?php

namespace Payavel\Checkout\Tests\Models;

use Payavel\Checkout\Models\PaymentType;

class TestPaymentType extends PaymentType
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_types';

    /**
     * Check if model is overridden for testing purposes.
     *
     * @var bool
     */
    public bool $overridden = true;
}
