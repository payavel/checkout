<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\Models\PaymentInstrument;
use Payavel\Checkout\Models\Wallet;
use Payavel\Checkout\Tests\Models\TestAccount;
use Payavel\Checkout\Tests\Models\TestPaymentInstrument;
use Payavel\Checkout\Tests\Models\TestProvider;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Checkout\Tests\User;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Support\ServiceConfig;
use PHPUnit\Framework\Attributes\Test;

class WalletModelTest extends TestCase
{
    #[Test]
    public function retrieve_wallet_billable()
    {
        $wallet = Wallet::factory()->create();
        $this->assertNull($wallet->billable);

        $billable = User::factory()->create();
        $walletWithBillable = Wallet::factory()->create();
        $walletWithBillable->billable()->associate($billable);
        $this->assertInstanceOf(Billable::class, $walletWithBillable->billable);
    }

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

    #[Test]
    public function retrieve_wallet_payment_instruments()
    {
        $wallet = Wallet::factory()->create();
        $this->assertEmpty($wallet->paymentInstruments);

        $walletWith2PaymentInstruments = Wallet::factory()->hasPaymentInstruments(2)->create();
        $this->assertCount(2, $walletWith2PaymentInstruments->paymentInstruments);
        $this->assertContainsOnlyInstancesOf(PaymentInstrument::class, $walletWith2PaymentInstruments->paymentInstruments);

        ServiceConfig::set('checkout', 'models.' . PaymentInstrument::class, TestPaymentInstrument::class);
        $walletWith3OverriddenPaymentInstruments = Wallet::factory()->hasPaymentInstruments(3)->create();
        $this->assertCount(3, $walletWith3OverriddenPaymentInstruments->paymentInstruments);
        $this->assertContainsOnlyInstancesOf(TestPaymentInstrument::class, $walletWith3OverriddenPaymentInstruments->paymentInstruments);
    }
}
