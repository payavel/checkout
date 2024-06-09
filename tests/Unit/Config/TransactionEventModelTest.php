<?php

namespace Payavel\Checkout\Tests\Unit\Config;

use Payavel\Checkout\Tests\Unit\TestTransactionEventModel;
use Payavel\Orchestration\Tests\Traits\CreatesConfigServiceables;
use Payavel\Orchestration\Tests\Traits\SetsConfigDriver;

class TransactionEventModelTest extends TestTransactionEventModel
{
    use CreatesConfigServiceables;
    use SetsConfigDriver;
}
