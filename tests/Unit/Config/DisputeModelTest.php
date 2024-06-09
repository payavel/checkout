<?php

namespace Payavel\Checkout\Tests\Unit\Config;

use Payavel\Checkout\Tests\Unit\TestDisputeModel;
use Payavel\Orchestration\Tests\Traits\CreatesConfigServiceables;
use Payavel\Orchestration\Tests\Traits\SetsConfigDriver;

class DisputeModelTest extends TestDisputeModel
{
    use CreatesConfigServiceables;
    use SetsConfigDriver;
}
