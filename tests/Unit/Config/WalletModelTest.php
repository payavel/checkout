<?php

namespace Payavel\Checkout\Tests\Unit\Config;

use Payavel\Checkout\Tests\Unit\TestWalletModel;
use Payavel\Orchestration\Tests\Traits\CreatesConfigServiceables;
use Payavel\Orchestration\Tests\Traits\SetsConfigDriver;

class WalletModelTest extends TestWalletModel
{
    use CreatesConfigServiceables;
    use SetsConfigDriver;
}
