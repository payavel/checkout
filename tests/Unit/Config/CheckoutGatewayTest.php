<?php

namespace Payavel\Checkout\Tests\Unit\Config;

use Payavel\Checkout\Tests\Unit\TestCheckoutGateway;
use Payavel\Orchestration\Tests\Traits\CreatesConfigServiceables;
use Payavel\Orchestration\Tests\Traits\SetsConfigDriver;

class CheckoutGatewayTest extends TestCheckoutGateway
{
    use CreatesConfigServiceables;
    use SetsConfigDriver;
}
