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
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Support\ServiceConfig;
use PHPUnit\Framework\Attributes\Test;

class PaymentInstrumentModelTest extends TestCase
{
    #[Test]
    public function retrieve_payment_instrument_provider()
    {
        $paymentInstrumentWithProviderViaWallet = PaymentInstrument::factory()->create();
        $this->assertInstanceOf(Provider::class, $paymentInstrumentWithProviderViaWallet->provider);

        ServiceConfig::set('checkout', 'models.' . Wallet::class, TestWallet::class);
        $paymentInstrumentWithProviderViaOverriddenWallet = PaymentInstrument::factory()->create();
        $this->assertInstanceOf(Provider::class, $paymentInstrumentWithProviderViaOverriddenWallet->provider);
    }

    #[Test]
    public function retrieve_payment_instrument_account()
    {
        $paymentInstrumentWithAccountViaWallet = PaymentInstrument::factory()->create();
        $this->assertInstanceOf(Account::class, $paymentInstrumentWithAccountViaWallet->account);

        ServiceConfig::set('checkout', 'models.' . Wallet::class, TestWallet::class);
        $paymentInstrumentWithAccountViaOverriddenWallet = PaymentInstrument::factory()->create();
        $this->assertInstanceOf(Account::class, $paymentInstrumentWithAccountViaOverriddenWallet->account);
    }

    #[Test]
    public function retrieve_payment_instrument_wallet()
    {
        $paymentInstrumentWithWallet = PaymentInstrument::factory()->create();
        $this->assertInstanceOf(Wallet::class, $paymentInstrumentWithWallet->wallet);

        ServiceConfig::set('checkout', 'models.' . Wallet::class, TestWallet::class);
        $paymentInstrumentWithOverriddenWallet = PaymentInstrument::factory()->create();
        $this->assertInstanceOf(TestWallet::class, $paymentInstrumentWithOverriddenWallet->wallet);
    }

    #[Test]
    public function retrieve_payment_instrument_type()
    {
        $paymentInstrumentWithType = PaymentInstrument::factory()->create();
        $this->assertInstanceOf(PaymentType::class, $paymentInstrumentWithType->type);

        ServiceConfig::set('checkout', 'models.' . PaymentType::class, TestPaymentType::class);
        $paymentInstrumentWithOverriddenType = PaymentInstrument::factory()->create();
        $this->assertInstanceOf(TestPaymentType::class, $paymentInstrumentWithOverriddenType->type);
    }

    #[Test]
    public function retrieve_payment_instrument_payments()
    {
        $paymentInstrument = PaymentInstrument::factory()->create();
        $this->assertEmpty($paymentInstrument->payments);

        $paymentInstrumentWith2Payments = PaymentInstrument::factory()->hasPayments(2)->create();
        $this->assertCount(2, $paymentInstrumentWith2Payments->payments);
        $this->assertContainsOnlyInstancesOf(Payment::class, $paymentInstrumentWith2Payments->payments);

        ServiceConfig::set('checkout', 'models.' . Payment::class, TestPayment::class);
        $paymentInstrumentWith3OverriddenPayments = PaymentInstrument::factory()->hasPayments(3)->create();
        $this->assertCount(3, $paymentInstrumentWith3OverriddenPayments->payments);
        $this->assertContainsOnlyInstancesOf(TestPayment::class, $paymentInstrumentWith3OverriddenPayments->payments);
    }
}
