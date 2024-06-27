<?php

namespace Payavel\Checkout\Tests\Feature\Console\Database;

use Payavel\Checkout\Tests\Feature\Console\TestCheckoutProviderCommand;
use Payavel\Orchestration\Tests\Traits\CreatesDatabaseServiceables;
use Payavel\Orchestration\Tests\Traits\SetsDatabaseDriver;

class CheckoutProviderCommandTest extends TestCheckoutProviderCommand
{
    use CreatesDatabaseServiceables;
    use SetsDatabaseDriver;
}
