<?php

namespace Payavel\Checkout\Tests\Unit\Database;

use Payavel\Checkout\Tests\Unit\TestPaymentTypeModel;
use Payavel\Orchestration\Tests\Traits\CreatesDatabaseServiceables;
use Payavel\Orchestration\Tests\Traits\SetsDatabaseDriver;

class PaymentTypeModelTest extends TestPaymentTypeModel
{
    use CreatesDatabaseServiceables;
    use SetsDatabaseDriver;
}
