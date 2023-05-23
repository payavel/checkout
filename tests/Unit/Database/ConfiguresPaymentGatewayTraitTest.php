<?php

namespace Payavel\Checkout\Tests\Unit\Database;

use Payavel\Checkout\Tests\Unit\TestConfiguresPaymentGatewayTrait;

class ConfiguresPaymentGatewayTraitTest extends TestConfiguresPaymentGatewayTrait
{
    protected $driver = 'database';
}
