<?php

namespace Payavel\Checkout\Tests\Models;

use Payavel\Checkout\Models\Dispute;

class TestDispute extends Dispute
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'disputes';

    /**
     * Check if model is overridden for testing purposes.
     *
     * @var bool
     */
    public bool $overridden = true;
}
