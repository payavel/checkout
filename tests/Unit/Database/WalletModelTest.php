<?php

namespace Payavel\Checkout\Tests\Unit\Database;

use Payavel\Checkout\Models\Wallet;
use Payavel\Checkout\Tests\Models\TestAccount;
use Payavel\Checkout\Tests\Models\TestProvider;
use Payavel\Checkout\Tests\Unit\TestWalletModel;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Support\ServiceConfig;
use Payavel\Orchestration\Tests\Traits\CreatesDatabaseServiceables;
use Payavel\Orchestration\Tests\Traits\SetsDatabaseDriver;
use PHPUnit\Framework\Attributes\Test;

class WalletModelTest extends TestWalletModel
{
    use CreatesDatabaseServiceables;
    use SetsDatabaseDriver;

    #[Test]
    public function retrieve_wallet_provider()
    {
        $walletWithProvider = Wallet::factory()->create();
        $this->assertInstanceOf(Provider::class, $walletWithProvider->provider);

        ServiceConfig::set('checkout', 'models.' . Provider::class, TestProvider::class);
        $walletWithOverriddenProvider = Wallet::factory()->create();
        $this->assertInstanceOF(TestProvider::class, $walletWithOverriddenProvider->provider);
    }

    #[Test]
    public function retrieve_wallet_account()
    {
        $walletWithAccount = Wallet::factory()->create();
        $this->assertInstanceOf(Account::class, $walletWithAccount->account);

        ServiceConfig::set('checkout', 'models.' . Account::class, TestAccount::class);
        $walletWithOverriddenAccount = Wallet::factory()->create();
        $this->assertInstanceOF(TestAccount::class, $walletWithOverriddenAccount->account);
    }
}
