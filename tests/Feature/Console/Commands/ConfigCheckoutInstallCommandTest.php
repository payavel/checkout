<?php

namespace Payavel\Checkout\Tests\Feature\Console\Commands;

use Illuminate\Support\Str;
use Payavel\Orchestration\Contracts\Accountable;
use Payavel\Orchestration\Contracts\Providable;
use Payavel\Orchestration\Tests\Traits\CreatesConfigServiceables;
use Payavel\Orchestration\Tests\Traits\SetsConfigDriver;

class ConfigCheckoutInstallCommandTest extends TestCheckoutInstallCommand
{
    use CreatesConfigServiceables;
    use SetsConfigDriver;

    protected function makeSureProviderExists(Providable $provider)
    {
        $config = require(config_path(Str::slug($this->checkoutConfig->id) . '.php'));

        $this->assertIsArray($config['providers']);
        $this->assertIsArray($config['providers'][$provider->getId()]);
        $this->assertEquals(
            'App\\Services\\' . Str::studly($this->checkoutConfig->id) . '\\' . Str::studly($provider->getId()) . Str::studly($this->checkoutConfig->id) . 'Request',
            $config['providers'][$provider->getId()]['gateway']
        );
    }

    protected function makeSureAccountExists(Accountable $account)
    {
        $config = require(config_path(Str::slug($this->checkoutConfig->id) . '.php'));

        $this->assertIsArray($config['accounts']);
        $this->assertIsArray($config['accounts'][$account->getId()]);
        $this->assertIsArray($config['accounts'][$account->getId()]['providers']);
        $this->assertNotEmpty($config['accounts'][$account->getId()]['providers']);
    }

    protected function makeSureProviderIsLinkedToAccount(Providable $provider, Accountable $account)
    {
        $config = require(config_path(Str::slug($this->checkoutConfig->id) . '.php'));

        $this->assertIsArray($config['accounts'][$account->getId()]['providers'][$provider->getId()]);
    }
}
