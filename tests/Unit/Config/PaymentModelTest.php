<?php

namespace Payavel\Checkout\Tests\Unit\Config;

use Payavel\Checkout\Tests\Unit\TestPaymentModel;
use Payavel\Orchestration\Tests\Traits\CreatesConfigServiceables;
use Payavel\Orchestration\Tests\Traits\SetsConfigDriver;

class PaymentModelTest extends TestPaymentModel
{
    use CreatesConfigServiceables;
    use SetsConfigDriver;
}
