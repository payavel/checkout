<?php

namespace Payavel\Checkout\Tests\Models;

use Payavel\Checkout\Models\Refund;
use PHPUnit\Framework\Attributes\Test;

class TestRefund extends Refund
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'refunds';

    /**
     * Check if model is overridden for testing purposes.
     *
     * @var bool
     */
    public bool $overridden = true;
}
