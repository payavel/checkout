<?php

namespace Payavel\Checkout\Tests\Unit\Database;

use Payavel\Checkout\Tests\Unit\TestPaymentRailModel;
use Payavel\Orchestration\Tests\Traits\CreatesDatabaseServiceables;
use Payavel\Orchestration\Tests\Traits\SetsDatabaseDriver;

class PaymentRailModelTest extends TestPaymentRailModel
{
    use CreatesDatabaseServiceables;
    use SetsDatabaseDriver;
}
