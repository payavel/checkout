<?php

namespace Payavel\Checkout\Tests\Unit\Database;

use Payavel\Checkout\Tests\Unit\TestDisputeModel;
use Payavel\Orchestration\Tests\Traits\CreatesDatabaseServiceables;
use Payavel\Orchestration\Tests\Traits\SetsDatabaseDriver;

class DisputeModelTest extends TestDisputeModel
{
    use CreatesDatabaseServiceables;
    use SetsDatabaseDriver;
}
