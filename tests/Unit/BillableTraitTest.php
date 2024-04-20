<?php

namespace Payavel\Checkout\Tests\Unit;

use Illuminate\Support\Facades\Config;
use Payavel\Checkout\Models\Wallet as WalletModel;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Checkout\Tests\User;
use Payavel\Orchestration\Support\ServiceConfig;
use PHPUnit\Framework\Attributes\Test;

class BillableTraitTest extends TestCase
{
    #[Test]
    public function retrieve_billable_wallets()
    {
        ServiceConfig::set('checkout', 'models.' . WalletModel::class, Wallet::class);

        $billable = User::factory()
            ->hasWallets(
                $totalWallets = rand(1, 3),
                ['provider_id' => 'fake', 'account_id' => 'faker']
            )
            ->create();

        $this->assertCount($totalWallets, $billable->wallets);

        $billable->wallets->each(
            fn ($wallet) => $this->assertTrue($wallet->isLocalModel)
        );
    }
}

class Wallet extends WalletModel
{
    public $isLocalModel = true;
}
