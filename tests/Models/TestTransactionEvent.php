<?php

namespace Payavel\Checkout\Tests\Models;

use Payavel\Checkout\Models\TransactionEvent;

class TestTransactionEvent extends TransactionEvent
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaction_events';

    /**
     * Check if model is overridden for testing purposes.
     */
    public bool $overridden = true;
}
