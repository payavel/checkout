<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Orchestration\Tests\Traits\CreatesDatabaseServiceables;
use Payavel\Orchestration\Tests\Traits\SetsDatabaseDriver;

class DatabaseCheckoutGatewayTest extends TestCheckoutGateway
{
    use CreatesDatabaseServiceables;
    use SetsDatabaseDriver;
}
