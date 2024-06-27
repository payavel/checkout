<?php

namespace Payavel\Checkout\Tests\Feature\Console\Config;

use Payavel\Checkout\Tests\Feature\Console\TestCheckoutProviderCommand;
use Payavel\Orchestration\Tests\Traits\CreatesConfigServiceables;
use Payavel\Orchestration\Tests\Traits\SetsConfigDriver;

class CheckoutProviderCommandTest extends TestCheckoutProviderCommand
{
    use CreatesConfigServiceables;
    use SetsConfigDriver;
}
