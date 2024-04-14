<?php

namespace Payavel\Checkout\Tests\Feature\Console\Commands;

use Payavel\Orchestration\Tests\Traits\CreatesConfigServiceables;
use Payavel\Orchestration\Tests\Traits\SetsConfigDriver;

class ConfigCheckoutProviderCommandTest extends TestCheckoutProviderCommand
{
    use CreatesConfigServiceables;
    use SetsConfigDriver;
}
