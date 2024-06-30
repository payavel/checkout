<?php

namespace Payavel\Checkout\Tests\Feature\Console\Database;

use Illuminate\Support\Str;
use Payavel\Checkout\Tests\Feature\Console\TestCheckoutInstallCommand;
use Payavel\Orchestration\Contracts\Accountable;
use Payavel\Orchestration\Contracts\Providable;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Tests\Traits\CreatesDatabaseServiceables;
use Payavel\Orchestration\Tests\Traits\SetsDatabaseDriver;

class CheckoutInstallCommandTest extends TestCheckoutInstallCommand
{
    use CreatesDatabaseServiceables;
    use SetsDatabaseDriver;

    /**
     * Determines if the generated migration has already been executed.
     *
     * @var boolean
     */
    private bool $migrated = false;

    protected function makeSureProviderExists(Providable $provider)
    {
        $this->migrate();

        $provider = Provider::find($provider->getId());

        $this->assertNotNull($provider);
        $this->assertEquals(
            'App\\Services\\' . Str::studly($this->checkoutConfig->id) . '\\' . Str::studly($provider->getId()) . Str::studly($this->checkoutConfig->id) . 'Request',
            $provider->gateway
        );
    }

    protected function makeSureAccountExists(Accountable $account)
    {
        $this->migrate();

        $account = Account::find($account->getId());

        $this->assertNotNull($account);
        $this->assertNotEmpty($account->providers);
    }

    protected function makeSureProviderIsLinkedToAccount(Providable $provider, Accountable $account)
    {
        $this->migrate();

        $provider = Provider::find($provider->getId());
        $account = Account::find($account->getId());

        $this->assertNotNull($provider->accounts()->where('accounts.id', $account->id)->first());
        $this->assertNotNull($account->providers()->where('providers.id', $provider->id)->first());
    }

    private function migrate()
    {
        if ($this->migrated) {
            return;
        }

        Account::where('service_id', $this->checkoutConfig->id)->delete();
        Provider::where('service_id', $this->checkoutConfig->id)->delete();

        $this->artisan('migrate');

        $this->migrated = true;
    }
}