<?php

namespace Payavel\Checkout\Tests\Unit\Config;

use Payavel\Checkout\Tests\Unit\TestRefundModel;
use Payavel\Orchestration\Tests\Traits\CreatesConfigServiceables;
use Payavel\Orchestration\Tests\Traits\SetsConfigDriver;

class RefundModelTest extends TestRefundModel
{
    use CreatesConfigServiceables;
    use SetsConfigDriver;
}
