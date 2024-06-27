<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\PaymentInstrument;
use Payavel\Checkout\Models\PaymentType;
use Payavel\Checkout\Models\Wallet;
use Payavel\Checkout\Tests\Models\TestPayment;
use Payavel\Checkout\Tests\Models\TestPaymentType;
use Payavel\Checkout\Tests\Models\TestWallet;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Fluent\ServiceConfig;
use Payavel\Orchestration\Tests\Contracts\CreatesServiceables;
use PHPUnit\Framework\Attributes\Test;

abstract class TestPaymentInstrumentModel extends TestCase implements CreatesServiceables
{
    #[Test]
    public function retrieve_payment_instrument_wallet()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => $this->createProvider($this->checkoutConfig)->getId(),
            'account_id' => $this->createAccount($this->checkoutConfig)->getId(),
        ]);

        $paymentInstrumentWithWallet = PaymentInstrument::factory()->for($wallet)->create();
        $this->assertInstanceOf(Wallet::class, $paymentInstrumentWithWallet->wallet);

        ServiceConfig::find('checkout')->set('models.' . Wallet::class, TestWallet::class);
        $paymentInstrumentWithOverriddenWallet = PaymentInstrument::factory()->for($wallet)->create();
        $this->assertInstanceOf(TestWallet::class, $paymentInstrumentWithOverriddenWallet->wallet);
    }

    #[Test]
    public function retrieve_payment_instrument_type()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => $this->createProvider($this->checkoutConfig)->getId(),
            'account_id' => $this->createAccount($this->checkoutConfig)->getId(),
        ]);

        $paymentInstrumentWithType = PaymentInstrument::factory()->for($wallet)->create();
        $this->assertInstanceOf(PaymentType::class, $paymentInstrumentWithType->type);

        ServiceConfig::find('checkout')->set('models.' . PaymentType::class, TestPaymentType::class);
        $paymentInstrumentWithOverriddenType = PaymentInstrument::factory()->for($wallet)->create();
        $this->assertInstanceOf(TestPaymentType::class, $paymentInstrumentWithOverriddenType->type);
    }

    #[Test]
    public function retrieve_payment_instrument_payments()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => $this->createProvider($this->checkoutConfig)->getId(),
            'account_id' => $this->createAccount($this->checkoutConfig)->getId(),
        ]);

        $paymentInstrument = PaymentInstrument::factory()->for($wallet)->create();
        $this->assertEmpty($paymentInstrument->payments);

        $paymentInstrumentWith2Payments = PaymentInstrument::factory()->for($wallet)->hasPayments(2)->create();
        $this->assertCount(2, $paymentInstrumentWith2Payments->payments);
        $this->assertContainsOnlyInstancesOf(Payment::class, $paymentInstrumentWith2Payments->payments);

        ServiceConfig::find('checkout')->set('models.' . Payment::class, TestPayment::class);
        $paymentInstrumentWith3OverriddenPayments = PaymentInstrument::factory()->for($wallet)->hasPayments(3)->create();
        $this->assertCount(3, $paymentInstrumentWith3OverriddenPayments->payments);
        $this->assertContainsOnlyInstancesOf(TestPayment::class, $paymentInstrumentWith3OverriddenPayments->payments);
    }
}
