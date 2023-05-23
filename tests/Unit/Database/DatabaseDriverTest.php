<?php

namespace Payavel\Checkout\Tests\Unit\Database;

use Payavel\Checkout\Tests\Unit\TestPaymentGateway;

class DriverTest extends TestPaymentGateway
{
    protected $driver = 'database';
}
