<?php

namespace Payavel\Checkout\Tests\Unit\Config;

use Payavel\Checkout\Tests\Unit\TestBillableTrait;
use Payavel\Orchestration\Tests\Traits\CreatesConfigServiceables;
use Payavel\Orchestration\Tests\Traits\SetsConfigDriver;

class BillableTraitTest extends TestBillableTrait
{
    use CreatesConfigServiceables;
    use SetsConfigDriver;
}
