<?php

namespace Payavel\Checkout\Tests\Unit\Database;

use Payavel\Checkout\Tests\Unit\TestCheckoutGateway;
use Payavel\Orchestration\Tests\Traits\CreatesDatabaseServiceables;
use Payavel\Orchestration\Tests\Traits\SetsDatabaseDriver;

class CheckoutGatewayTest extends TestCheckoutGateway
{
    use CreatesDatabaseServiceables;
    use SetsDatabaseDriver;
}
