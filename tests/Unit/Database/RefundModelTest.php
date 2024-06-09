<?php

namespace Payavel\Checkout\Tests\Unit\Database;

use Payavel\Checkout\Tests\Unit\TestRefundModel;
use Payavel\Orchestration\Tests\Traits\CreatesDatabaseServiceables;
use Payavel\Orchestration\Tests\Traits\SetsDatabaseDriver;

class RefundModelTest extends TestRefundModel
{
    use CreatesDatabaseServiceables;
    use SetsDatabaseDriver;
}
