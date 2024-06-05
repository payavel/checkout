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
use Payavel\Orchestration\Contracts\Accountable;
use Payavel\Orchestration\Contracts\Providable;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Support\ServiceConfig;
use Payavel\Orchestration\Tests\Contracts\CreatesServiceables;
use PHPUnit\Framework\Attributes\Test;

abstract class TestWalletModel extends TestCase implements CreatesServiceables
{
    #[Test]
    public function retrieve_wallet_billable()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ]);
        $this->assertNull($wallet->billable);

        $walletWithBillable = Wallet::factory()->for(User::factory()->create(), 'billable')->create([
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ]);
        $this->assertInstanceOf(User::class, $walletWithBillable->billable);
        $this->assertInstanceOf(Billable::class, $walletWithBillable->billable);
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

    #[Test]
    public function retrieve_wallet_providable()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ]);
        $this->assertInstanceOf(Providable::class, $wallet->getProvider());
    }

    #[Test]
    public function retrieve_wallet_accountable()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ]);
        $this->assertInstanceOf(Accountable::class, $wallet->getAccount());
    }
}
