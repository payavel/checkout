<?php

namespace Payavel\Checkout\Tests\Unit\Database;

use Payavel\Checkout\Tests\Unit\TestBillableTrait;
use Payavel\Orchestration\Tests\Traits\CreatesDatabaseServiceables;
use Payavel\Orchestration\Tests\Traits\SetsDatabaseDriver;

class BillableTraitTest extends TestBillableTrait
{
    use CreatesDatabaseServiceables;
    use SetsDatabaseDriver;
}
