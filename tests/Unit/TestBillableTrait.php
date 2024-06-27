<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\Models\Wallet;
use Payavel\Checkout\Tests\Models\TestWallet;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Checkout\Tests\User;
use Payavel\Orchestration\Fluent\ServiceConfig;
use Payavel\Orchestration\Tests\Contracts\CreatesServiceables;
use PHPUnit\Framework\Attributes\Test;

abstract class TestBillableTrait extends TestCase implements CreatesServiceables
{
    #[Test]
    public function retrieve_billable_wallets()
    {
        $billable = User::factory()->create();
        $this->assertEmpty($billable->wallets);

        $billableWith2Wallets = User::factory()->has(Wallet::factory()->count(2)->sequence(fn () => [
            'provider_id' => $this->createProvider($this->checkoutConfig)->getId(),
            'account_id' => $this->createAccount($this->checkoutConfig)->getId(),
        ]))->create();
        $this->assertCount(2, $billableWith2Wallets->wallets);
        $this->assertContainsOnlyInstancesOf(Wallet::class, $billableWith2Wallets->wallets);

        $this->checkoutConfig->set('models.'.Wallet::class, TestWallet::class);
        $billableWith3OverriddenWallets = User::factory()->has(Wallet::factory()->count(3)->sequence(fn () => [
            'provider_id' => $this->createProvider($this->checkoutConfig)->getId(),
            'account_id' => $this->createAccount($this->checkoutConfig)->getId(),
        ]))->create();
        $this->assertCount(3, $billableWith3OverriddenWallets->wallets);
        $this->assertContainsOnlyInstancesOf(TestWallet::class, $billableWith3OverriddenWallets->wallets);
    }
}
