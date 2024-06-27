<?php

namespace Payavel\Checkout\Tests\Feature\Console\Commands;

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

        $checkoutServiceConfig = $this->configPath($this->checkoutConfig);
        $checkoutServiceContract = $this->contractPath($this->checkoutConfig);
        $fakeGateway = $this->gatewayPath($this->checkoutConfig);
        $providerGateway = $this->gatewayPath($this->checkoutConfig, $provider);

        $ds = DIRECTORY_SEPARATOR;
        $this->artisan('checkout:install')
            ->expectsQuestion("Choose a driver for the {$this->checkoutConfig->name} service.", Config::get('orchestration.defaults.driver'))
            ->expectsQuestion("How should the {$this->checkoutConfig->name} provider be named?", $provider->getName())
            ->expectsQuestion("How should the {$this->checkoutConfig->name} provider be identified?", $provider->getId())
            ->expectsConfirmation("Would you like to add another {$this->checkoutConfig->name} provider?", 'no')
            ->expectsQuestion("How should the {$this->checkoutConfig->name} account be named?", $account->getName())
            ->expectsQuestion("How should the {$this->checkoutConfig->name} account be identified?", $account->getId())
            ->expectsConfirmation("Would you like to add another {$this->checkoutConfig->name} account?", 'no')
            ->expectsOutputToContain("Config [config{$ds}{$checkoutServiceConfig->orchestration}] created successfully.")
            ->expectsOutputToContain("Config [config{$ds}{$checkoutServiceConfig->service}] created successfully.")
            ->expectsOutputToContain("Contract [app{$ds}{$checkoutServiceContract->requester}] created successfully.")
            ->expectsOutputToContain("Contract [app{$ds}{$checkoutServiceContract->responder}] created successfully.")
            ->expectsOutputToContain("Gateway [app{$ds}{$fakeGateway->request}] created successfully.")
            ->expectsOutputToContain("Gateway [app{$ds}{$fakeGateway->response}] created successfully.")
            ->expectsOutputToContain("Gateway [app{$ds}{$providerGateway->request}] created successfully.")
            ->expectsOutputToContain("Gateway [app{$ds}{$providerGateway->response}] created successfully.")
            ->assertSuccessful();

        $config = require(config_path($checkoutServiceConfig->service));

        $this->assertContractExists($this->checkoutConfig);
        $this->assertGatewayExists($this->checkoutConfig);
        $this->assertGatewayExists($this->checkoutConfig, $provider);

        $this->assertEquals($provider->getId(), $config['defaults']['provider']);
        $this->assertEquals($account->getId(), $config['defaults']['account']);

        $this->makeSureProviderExists($provider);
        $this->makeSureAccountExists($account);
        $this->makeSureProviderIsLinkedToAccount($provider, $account);

        $this->assertTrue(unlink(config_path($checkoutServiceConfig->service)));
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
