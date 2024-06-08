<?php

namespace Payavel\Checkout\Tests\Unit\Config;

use Payavel\Checkout\Tests\Unit\TestPaymentTypeModel;
use Payavel\Orchestration\Tests\Traits\CreatesConfigServiceables;
use Payavel\Orchestration\Tests\Traits\SetsConfigDriver;

class PaymentTypeModelTest extends TestPaymentTypeModel
{
    use CreatesConfigServiceables;
    use SetsConfigDriver;
}
