<?php

namespace Payavel\Checkout\Tests\Feature\Console\Commands;

use Illuminate\Support\Str;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Service;
use Payavel\Orchestration\Tests\Traits\AssertsGatewayExists;
use Payavel\Orchestration\Tests\Traits\CreatesServiceables;

class InstallCommandTest extends TestCase
{
    use AssertsGatewayExists,
        CreatesServiceables;

    /** @test */
    public function install_command_defaults_to_checkout_service()
    {
        $service = Service::find('checkout');
        $lowerCaseService = Str::lower($service->getName());

        $provider = $this->createProvider($service);

        $merchant = $this->createMerchant($service);

        $this->artisan('checkout:install')
            ->expectsQuestion('What ' . $lowerCaseService . ' provider would you like to add?', $provider->getName())
            ->expectsQuestion('How would you like to identify the ' . $provider->getName() . ' ' . $lowerCaseService . ' provider?', $provider->getId())
            ->expectsConfirmation('Would you like to add another ' . $lowerCaseService . ' provider?', 'no')
            ->expectsQuestion('What ' . $lowerCaseService . ' merchant would you like to add?', $merchant->getName())
            ->expectsQuestion('How would you like to identify the ' . $merchant->getName() . ' ' . $lowerCaseService . ' merchant?', $merchant->getId())
            ->expectsConfirmation('Would you like to add another ' . $lowerCaseService . ' merchant?', 'no')
            ->expectsOutput('The ' . $lowerCaseService . ' config has been successfully generated.')
            ->expectsOutput('Fake ' . $lowerCaseService . ' gateway generated successfully!')
            ->expectsOutput($provider->getName() . ' ' . $lowerCaseService . ' gateway generated successfully!')
            ->assertExitCode(0);

        $configFile = Str::slug($service->getName()) . '.php';

        $this->assertFileExists(config_path($configFile));
        $config = require(config_path($configFile));

        $this->assertGatewayExists($service);

        $this->assertEquals($provider->getId(), $config['defaults']['provider']);
        $this->assertEquals($merchant->getId(), $config['defaults']['merchant']);
        $this->assertEquals($provider->getName(), $config['providers'][$provider->getId()]['name']);
        $this->assertEquals($merchant->getName(), $config['merchants'][$merchant->getId()]['name']);
        $this->assertNotNull($config['merchants'][$merchant->getId()]['providers'][$provider->getId()]);

        $this->assertGatewayExists($provider);

        $this->assertTrue(unlink(config_path($configFile)));
    }
}
