<?php

namespace Payavel\Checkout\Tests\Models;

use Payavel\Orchestration\Models\Provider;

class TestProvider extends Provider
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'providers';

    /**
     * Check if model is overridden for testing purposes.
     *
     * @var bool
     */
    public bool $overridden = true;
}
