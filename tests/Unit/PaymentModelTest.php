<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\PaymentInstrument;
use Payavel\Checkout\Models\PaymentRail;
use Payavel\Checkout\Models\TransactionEvent;
use Payavel\Checkout\Tests\Models\TestAccount;
use Payavel\Checkout\Tests\Models\TestPaymentInstrument;
use Payavel\Checkout\Tests\Models\TestPaymentRail;
use Payavel\Checkout\Tests\Models\TestProvider;
use Payavel\Checkout\Tests\Models\TestTransactionEvent;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Support\ServiceConfig;
use PHPUnit\Framework\Attributes\Test;

class PaymentModelTest extends TestCase
{
    #[Test]
    public function retrieve_payment_provider()
    {
        $paymentWithProvider = Payment::factory()->create();
        $this->assertInstanceOf(Provider::class, $paymentWithProvider->provider);

        ServiceConfig::set('checkout', 'models.' . Provider::class, TestProvider::class);
        $paymentWithOverriddenProvider = Payment::factory()->create();
        $this->assertInstanceOf(TestProvider::class, $paymentWithOverriddenProvider->provider);
    }

    #[Test]
    public function retrieve_payment_account()
    {
        $paymentWithAccount = Payment::factory()->create();
        $this->assertInstanceOf(Account::class, $paymentWithAccount->account);

        ServiceConfig::set('checkout', 'models.' . Account::class, TestAccount::class);
        $paymentWithOverriddenAccount = Payment::factory()->create();
        $this->assertInstanceOf(TestAccount::class, $paymentWithOverriddenAccount->account);
    }

    #[Test]
    public function retrieve_payment_rail()
    {
        $paymentWithRail = Payment::factory()->create();
        $this->assertInstanceOf(PaymentRail::class, $paymentWithRail->rail);

        ServiceConfig::set('checkout', 'models.' . PaymentRail::class, TestPaymentRail::class);
        $paymentWithOverriddenRail = Payment::factory()->create();
        $this->assertInstanceOf(TestPaymentRail::class, $paymentWithOverriddenRail->rail);
    }

    #[Test]
    public function retrieve_payment_instrument()
    {
        $payment = Payment::factory()->create();
        $this->assertNull($payment->instrument);

        $paymentWithInstrument = Payment::factory()->forInstrument()->create();
        $this->assertInstanceOf(PaymentInstrument::class, $paymentWithInstrument->instrument);

        ServiceConfig::set('checkout', 'models.' . PaymentInstrument::class, TestPaymentInstrument::class);
        $paymentWithOverriddenInstrument = Payment::factory()->forInstrument()->create();
        $this->assertInstanceOf(TestPaymentInstrument::class, $paymentWithOverriddenInstrument->instrument);
    }

    #[Test]
    public function retrieve_payment_events()
    {
        $payment = Payment::factory()->create();
        $this->assertEmpty($payment->events);

        $paymentWith2Events = Payment::factory()->hasEvents(2)->create();
        $this->assertCount(2, $paymentWith2Events->events);
        $this->assertContainsOnlyInstancesOf(TransactionEvent::class, $paymentWith2Events->events);

        ServiceConfig::set('checkout', 'models.' . TransactionEvent::class, TestTransactionEvent::class);
        $paymentWith3OverriddenEvents = Payment::factory()->hasEvents(3)->create();
        $this->assertCount(3, $paymentWith3OverriddenEvents->events);
        $this->assertContainsOnlyInstancesOf(TestTransactionEvent::class, $paymentWith3OverriddenEvents->events);
    }

    #[Test]
    public function retrieve_payment_transaction_events()
    {
        $payment = Payment::factory()->create();
        $this->assertEmpty($payment->transactionEvents);

        $paymentWith2TransactionEvents = Payment::factory()->hasTransactionEvents(2)->create();
        $this->assertCount(2, $paymentWith2TransactionEvents->transactionEvents);
        $this->assertContainsOnlyInstancesOf(TransactionEvent::class, $paymentWith2TransactionEvents->transactionEvents);

        ServiceConfig::set('checkout', 'models.' . TransactionEvent::class, TestTransactionEvent::class);
        $paymentWith3OverriddenTransactionEvents = Payment::factory()->hasTransactionEvents(3)->create();
        $this->assertCount(3, $paymentWith3OverriddenTransactionEvents->transactionEvents);
        $this->assertContainsOnlyInstancesOf(TestTransactionEvent::class, $paymentWith3OverriddenTransactionEvents->transactionEvents);
    }
}
