<?php

namespace Payavel\Checkout\Tests\Unit\Config;

use Payavel\Checkout\Tests\Unit\TestPaymentRailModel;
use Payavel\Orchestration\Tests\Traits\CreatesConfigServiceables;
use Payavel\Orchestration\Tests\Traits\SetsConfigDriver;

class PaymentRailModelTest extends TestPaymentRailModel
{
    use CreatesConfigServiceables;
    use SetsConfigDriver;
}
