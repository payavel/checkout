<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\Models\PaymentInstrument;
use Payavel\Checkout\Models\Wallet;
use Payavel\Checkout\Tests\Models\TestPaymentInstrument;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Checkout\Tests\User;
use Payavel\Orchestration\Contracts\Accountable;
use Payavel\Orchestration\Contracts\Providable;
use Payavel\Orchestration\Tests\Contracts\CreatesServiceables;
use PHPUnit\Framework\Attributes\Test;

abstract class TestWalletModel extends TestCase implements CreatesServiceables
{
    #[Test]
    public function retrieve_wallet_billable()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutConfig)->getId(),
            'account_id' => $this->createAccount($this->checkoutConfig)->getId(),
        ];

        $wallet = Wallet::factory()->create($usingServiceables);
        $this->assertNull($wallet->billable);

        $walletWithBillable = Wallet::factory()->for(User::factory()->create(), 'billable')->create($usingServiceables);
        $this->assertInstanceOf(User::class, $walletWithBillable->billable);
        $this->assertInstanceOf(Billable::class, $walletWithBillable->billable);
    }

    #[Test]
    public function retrieve_wallet_payment_instruments()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutConfig)->getId(),
            'account_id' => $this->createAccount($this->checkoutConfig)->getId(),
        ];

        $wallet = Wallet::factory()->create($usingServiceables);
        $this->assertEmpty($wallet->paymentInstruments);

        $walletWith2PaymentInstruments = Wallet::factory()->hasPaymentInstruments(2)->create($usingServiceables);
        $this->assertCount(2, $walletWith2PaymentInstruments->paymentInstruments);
        $this->assertContainsOnlyInstancesOf(PaymentInstrument::class, $walletWith2PaymentInstruments->paymentInstruments);

        $this->checkoutConfig->set('models.' . PaymentInstrument::class, TestPaymentInstrument::class);
        $walletWith3OverriddenPaymentInstruments = Wallet::factory()->hasPaymentInstruments(3)->create($usingServiceables);
        $this->assertCount(3, $walletWith3OverriddenPaymentInstruments->paymentInstruments);
        $this->assertContainsOnlyInstancesOf(TestPaymentInstrument::class, $walletWith3OverriddenPaymentInstruments->paymentInstruments);
    }

    #[Test]
    public function retrieve_wallet_providable()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutConfig)->getId(),
            'account_id' => $this->createAccount($this->checkoutConfig)->getId(),
        ];

        $wallet = Wallet::factory()->create($usingServiceables);
        $this->assertInstanceOf(Providable::class, $wallet->getProvider());
    }

    #[Test]
    public function retrieve_wallet_accountable()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutConfig)->getId(),
            'account_id' => $this->createAccount($this->checkoutConfig)->getId(),
        ];

        $wallet = Wallet::factory()->create($usingServiceables);
        $this->assertInstanceOf(Accountable::class, $wallet->getAccount());
    }
}
