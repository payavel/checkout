<?php

namespace Payavel\Checkout\Tests\Unit;

use Illuminate\Support\Facades\Config;
use Payavel\Checkout\Models\Wallet as WalletModel;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Checkout\Tests\User;

class BillableTraitTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('vendor:publish', [
            '--provider' => 'Payavel\\Checkout\\PaymentServiceProvider',
            '--tag' => 'payavel-migrations'
        ]);

        $this->artisan('migrate');
    }

    /** @test */
    public function retrieve_billable_wallets()
    {
        Config::set('payment.models.' . WalletModel::class, Wallet::class);

        $billable = User::factory()
            ->hasWallets(
                $totalWallets = rand(1, 3),
                ['provider_id' => 'fake', 'merchant_id' => 'faker']
            )
            ->create();

        $this->assertCount($totalWallets, $billable->wallets);

        $billable->wallets->each(function ($wallet) {
            $this->assertTrue($wallet->isLocalModel);
        });
    }
}

class Wallet extends WalletModel
{
    public $isLocalModel = true;
}
