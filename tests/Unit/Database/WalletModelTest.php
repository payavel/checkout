<?php

namespace Payavel\Checkout\Tests\Unit\Database;

use Payavel\Checkout\Models\Wallet;
use Payavel\Checkout\Tests\Models\TestAccount;
use Payavel\Checkout\Tests\Models\TestProvider;
use Payavel\Checkout\Tests\Unit\TestWalletModel;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Fluent\ServiceConfig;
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
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ];

        $walletWithProvider = Wallet::factory()->create($usingServiceables);
        $this->assertInstanceOf(Provider::class, $walletWithProvider->provider);

        ServiceConfig::find('checkout')->set('models.' . Provider::class, TestProvider::class);
        $walletWithOverriddenProvider = Wallet::factory()->create($usingServiceables);
        $this->assertInstanceOF(TestProvider::class, $walletWithOverriddenProvider->provider);
    }

    #[Test]
    public function retrieve_wallet_account()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ];

        $walletWithAccount = Wallet::factory()->create($usingServiceables);
        $this->assertInstanceOf(Account::class, $walletWithAccount->account);

        ServiceConfig::find('checkout')->set('models.' . Account::class, TestAccount::class);
        $walletWithOverriddenAccount = Wallet::factory()->create($usingServiceables);
        $this->assertInstanceOF(TestAccount::class, $walletWithOverriddenAccount->account);
    }
}
