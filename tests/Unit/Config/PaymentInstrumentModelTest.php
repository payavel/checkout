<?php

namespace Payavel\Checkout\Tests\Unit\Config;

use Payavel\Checkout\Tests\Unit\TestPaymentInstrumentModel;
use Payavel\Orchestration\Tests\Traits\CreatesConfigServiceables;
use Payavel\Orchestration\Tests\Traits\SetsConfigDriver;

class PaymentInstrumentModelTest extends TestPaymentInstrumentModel
{
    use CreatesConfigServiceables;
    use SetsConfigDriver;
}
