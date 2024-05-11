<?php

namespace Payavel\Checkout\Tests\Models;

use Payavel\Checkout\Models\Wallet;

class TestWallet extends Wallet
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wallets';

    /**
     * Check if model is overridden for testing purposes.
     *
     * @var bool
     */
    public bool $overridden = true;
}
