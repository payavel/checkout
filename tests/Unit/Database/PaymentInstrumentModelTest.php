<?php

namespace Payavel\Checkout\Tests\Unit\Database;

use Payavel\Checkout\Tests\Unit\TestPaymentInstrumentModel;
use Payavel\Orchestration\Tests\Traits\CreatesDatabaseServiceables;
use Payavel\Orchestration\Tests\Traits\SetsDatabaseDriver;

class PaymentInstrumentModelTest extends TestPaymentInstrumentModel
{
    use CreatesDatabaseServiceables;
    use SetsDatabaseDriver;
}
