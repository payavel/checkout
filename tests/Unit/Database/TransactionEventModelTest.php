<?php

namespace Payavel\Checkout\Tests\Unit\Database;

use Payavel\Checkout\Tests\Unit\TestTransactionEventModel;
use Payavel\Orchestration\Tests\Traits\CreatesDatabaseServiceables;
use Payavel\Orchestration\Tests\Traits\SetsDatabaseDriver;

class TransactionEventModelTest extends TestTransactionEventModel
{
    use CreatesDatabaseServiceables;
    use SetsDatabaseDriver;
}
