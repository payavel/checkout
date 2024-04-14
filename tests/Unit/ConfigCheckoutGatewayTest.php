<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Orchestration\Tests\Traits\CreatesConfigServiceables;
use Payavel\Orchestration\Tests\Traits\SetsConfigDriver;

class ConfigCheckoutGatewayTest extends TestCheckoutGateway
{
    use CreatesConfigServiceables;
    use SetsConfigDriver;
}
