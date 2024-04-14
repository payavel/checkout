<?php

namespace Payavel\Checkout\Tests\Feature\Console\Commands;

use Payavel\Orchestration\Tests\Traits\CreatesDatabaseServiceables;
use Payavel\Orchestration\Tests\Traits\SetsDatabaseDriver;

class DatabaseCheckoutProviderCommandTest extends TestCheckoutProviderCommand
{
    use CreatesDatabaseServiceables;
    use SetsDatabaseDriver;
}
