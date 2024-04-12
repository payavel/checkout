<?php

namespace Payavel\Checkout\Tests\Feature\Console\Commands;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Service;
use Payavel\Orchestration\Tests\Contracts\CreatesServiceables;
use Payavel\Orchestration\Tests\Traits\AssertsServiceExists;
use PHPUnit\Framework\Attributes\Test;

abstract class TestCheckoutInstallCommand extends TestCase implements CreatesServiceables
{
    use AssertsServiceExists;

    #[Test]
    public function install_command_publishes_migration_and_generates_config_with_single_provider_and_account()
    {
        $provider = $this->createProvider($this->checkoutService);
        $account = $this->createAccount($this->checkoutService);

        $checkoutServiceConfig = $this->configPath($this->checkoutService);
        $checkoutServiceContract = $this->contractPath($this->checkoutService);
        $fakeGateway = $this->gatewayPath($this->checkoutService);
        $providerGateway = $this->gatewayPath($provider);

        $this->artisan('checkout:install')
            ->expectsQuestion("Choose a driver for the {$this->checkoutService->getName()} service.", Config::get('orchestration.defaults.driver'))
            ->expectsQuestion("How should the {$this->checkoutService->getName()} provider be named?", $provider->getName())
            ->expectsQuestion("How should the {$this->checkoutService->getName()} provider be identified?", $provider->getId())
            ->expectsConfirmation("Would you like to add another {$this->checkoutService->getName()} provider?", 'no')
            ->expectsQuestion("How should the {$this->checkoutService->getName()} account be named?", $account->getName())
            ->expectsQuestion("How should the {$this->checkoutService->getName()} account be identified?", $account->getId())
            ->expectsConfirmation("Would you like to add another {$this->checkoutService->getName()} account?", 'no')
            ->expectsOutputToContain("Config [config/{$checkoutServiceConfig->orchestration}] created successfully.")
            ->expectsOutputToContain("Config [config/{$checkoutServiceConfig->service}] created successfully.")
            ->expectsOutputToContain("Contract [app/{$checkoutServiceContract->requester}] created successfully.")
            ->expectsOutputToContain("Contract [app/{$checkoutServiceContract->responder}] created successfully.")
            ->expectsOutputToContain("Gateway [app/{$fakeGateway->request}] created successfully.")
            ->expectsOutputToContain("Gateway [app/{$fakeGateway->response}] created successfully.")
            ->expectsOutputToContain("Gateway [app/{$providerGateway->request}] created successfully.")
            ->expectsOutputToContain("Gateway [app/{$providerGateway->response}] created successfully.")
            ->assertSuccessful();

        $config = require(config_path($checkoutServiceConfig->service));

        $this->assertContractExists($this->checkoutService);
        $this->assertGatewayExists($this->checkoutService);
        $this->assertGatewayExists($provider);

        $this->assertEquals($provider->getId(), $config['defaults']['provider']);
        $this->assertEquals($account->getId(), $config['defaults']['account']);

        $this->makeSureProviderExists($provider);
        $this->makeSureAccountExists($account);
        $this->makeSureProviderIsLinkedToAccount($provider, $account);

        $this->assertTrue(unlink(config_path($checkoutServiceConfig->service)));
    }
}
