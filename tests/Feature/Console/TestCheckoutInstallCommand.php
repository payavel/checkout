<?php

namespace Payavel\Checkout\Tests\Feature\Console;

use Illuminate\Support\Facades\Config;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Contracts\Accountable;
use Payavel\Orchestration\Contracts\Providable;
use Payavel\Orchestration\Tests\Contracts\CreatesServiceables;
use Payavel\Orchestration\Tests\Traits\AssertsServiceExists;
use PHPUnit\Framework\Attributes\Test;

abstract class TestCheckoutInstallCommand extends TestCase implements CreatesServiceables
{
    use AssertsServiceExists;

    #[Test]
    public function checkout_install_command_injects_checkout_service_into_orchestrate_service_command()
    {
        $provider = $this->createProvider($this->checkoutConfig);
        $account = $this->createAccount($this->checkoutConfig);

        $configPath = $this->configPath($this->checkoutConfig);
        $contractPath = $this->contractPath($this->checkoutConfig);
        $fakeGatewayPath = $this->gatewayPath($this->checkoutConfig);
        $providerGatewayPath = $this->gatewayPath($this->checkoutConfig, $provider);

        $ds = DIRECTORY_SEPARATOR;
        $this->artisan('checkout:install')
            ->expectsQuestion("Choose a driver for the {$this->checkoutConfig->name} service.", Config::get('orchestration.defaults.driver'))
            ->expectsQuestion("How should the {$this->checkoutConfig->name} provider be named?", $provider->getName())
            ->expectsQuestion("How should the {$this->checkoutConfig->name} provider be identified?", $provider->getId())
            ->expectsConfirmation("Would you like to add another {$this->checkoutConfig->name} provider?", 'no')
            ->expectsQuestion("How should the {$this->checkoutConfig->name} account be named?", $account->getName())
            ->expectsQuestion("How should the {$this->checkoutConfig->name} account be identified?", $account->getId())
            ->expectsConfirmation("Would you like to add another {$this->checkoutConfig->name} account?", 'no')
            ->expectsOutputToContain("Config [config{$ds}{$configPath->orchestration}] created successfully.")
            ->expectsOutputToContain("Config [config{$ds}{$configPath->service}] created successfully.")
            ->expectsOutputToContain("Contract [app{$ds}{$contractPath->requester}] created successfully.")
            ->expectsOutputToContain("Contract [app{$ds}{$contractPath->responder}] created successfully.")
            ->expectsOutputToContain("Gateway [app{$ds}{$fakeGatewayPath->request}] created successfully.")
            ->expectsOutputToContain("Gateway [app{$ds}{$fakeGatewayPath->response}] created successfully.")
            ->expectsOutputToContain("Gateway [app{$ds}{$providerGatewayPath->request}] created successfully.")
            ->expectsOutputToContain("Gateway [app{$ds}{$providerGatewayPath->response}] created successfully.")
            ->assertSuccessful();

        $serviceConfig = require(config_path($configPath->service));

        $this->assertContractExists($this->checkoutConfig);
        $this->assertGatewayExists($this->checkoutConfig);
        $this->assertGatewayExists($this->checkoutConfig, $provider);

        $this->assertEquals($provider->getId(), $serviceConfig['defaults']['provider']);
        $this->assertEquals($account->getId(), $serviceConfig['defaults']['account']);

        $this->makeSureProviderExists($provider);
        $this->makeSureAccountExists($account);
        $this->makeSureProviderIsLinkedToAccount($provider, $account);

        $this->assertTrue(unlink(config_path($configPath->service)));
    }

    protected function makeSureProviderExists(Providable $provider)
    {
        //
    }

    protected function makeSureAccountExists(Accountable $account)
    {
        //
    }

    protected function makeSureProviderIsLinkedToAccount(Providable $provider, Accountable $account)
    {
        //
    }
}
