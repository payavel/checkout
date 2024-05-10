<?php

namespace Payavel\Checkout\Tests\Models;

use Payavel\Orchestration\Models\Account;

class TestAccount extends Account
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
     * Check if model is overridden for testing purposes.
     *
     * @var bool
     */
    public bool $overridden = true;
}
