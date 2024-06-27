<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\CheckoutStatus;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\PaymentInstrument;
use Payavel\Checkout\Models\PaymentRail;
use Payavel\Checkout\Models\TransactionEvent;
use Payavel\Checkout\Models\Wallet;
use Payavel\Checkout\Tests\Models\TestPaymentInstrument;
use Payavel\Checkout\Tests\Models\TestPaymentRail;
use Payavel\Checkout\Tests\Models\TestTransactionEvent;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Contracts\Accountable;
use Payavel\Orchestration\Contracts\Providable;
use Payavel\Orchestration\Fluent\ServiceConfig;
use Payavel\Orchestration\Tests\Contracts\CreatesServiceables;
use PHPUnit\Framework\Attributes\Test;

abstract class TestPaymentModel extends TestCase implements CreatesServiceables
{
    #[Test]
    public function retrieve_payment_rail()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ];

        $paymentWithRail = Payment::factory()->create($usingServiceables);
        $this->assertInstanceOf(PaymentRail::class, $paymentWithRail->rail);

        ServiceConfig::find('checkout')->set('models.' . PaymentRail::class, TestPaymentRail::class);
        $paymentWithOverriddenRail = Payment::factory()->create($usingServiceables);
        $this->assertInstanceOf(TestPaymentRail::class, $paymentWithOverriddenRail->rail);
    }

    #[Test]
    public function retrieve_payment_instrument()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ];

        $payment = Payment::factory()->create($usingServiceables);
        $this->assertNull($payment->instrument);

        $paymentWithInstrument = Payment::factory()->for(PaymentInstrument::factory()->for(Wallet::factory()->create($usingServiceables))->create(), 'instrument')->create($usingServiceables);
        $this->assertInstanceOf(PaymentInstrument::class, $paymentWithInstrument->instrument);

        ServiceConfig::find('checkout')->set('models.' . PaymentInstrument::class, TestPaymentInstrument::class);
        $paymentWithOverriddenInstrument = Payment::factory()->for(PaymentInstrument::factory()->for(Wallet::factory()->create($usingServiceables))->create(), 'instrument')->create($usingServiceables);
        $this->assertInstanceOf(TestPaymentInstrument::class, $paymentWithOverriddenInstrument->instrument);
    }

    #[Test]
    public function retrieve_payment_events()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ];

        $payment = Payment::factory()->create($usingServiceables);
        $this->assertEmpty($payment->events);

        $paymentWith2Events = Payment::factory()->hasEvents(2, ['status_code' => CheckoutStatus::AUTHORIZED])->create($usingServiceables);
        $this->assertCount(2, $paymentWith2Events->events);
        $this->assertContainsOnlyInstancesOf(TransactionEvent::class, $paymentWith2Events->events);

        ServiceConfig::find('checkout')->set('models.' . TransactionEvent::class, TestTransactionEvent::class);
        $paymentWith3OverriddenEvents = Payment::factory()->hasEvents(3, ['status_code' => CheckoutStatus::AUTHORIZED])->create($usingServiceables);
        $this->assertCount(3, $paymentWith3OverriddenEvents->events);
        $this->assertContainsOnlyInstancesOf(TestTransactionEvent::class, $paymentWith3OverriddenEvents->events);
    }

    #[Test]
    public function retrieve_payment_transaction_events()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ];

        $payment = Payment::factory()->create($usingServiceables);
        $this->assertEmpty($payment->transactionEvents);

        $paymentWith2TransactionEvents = Payment::factory()->hasTransactionEvents(2)->create($usingServiceables);
        $this->assertCount(2, $paymentWith2TransactionEvents->transactionEvents);
        $this->assertContainsOnlyInstancesOf(TransactionEvent::class, $paymentWith2TransactionEvents->transactionEvents);

        ServiceConfig::find('checkout')->set('models.' . TransactionEvent::class, TestTransactionEvent::class);
        $paymentWith3OverriddenTransactionEvents = Payment::factory()->hasTransactionEvents(3)->create($usingServiceables);
        $this->assertCount(3, $paymentWith3OverriddenTransactionEvents->transactionEvents);
        $this->assertContainsOnlyInstancesOf(TestTransactionEvent::class, $paymentWith3OverriddenTransactionEvents->transactionEvents);
    }

    #[Test]
    public function retrieve_payment_providable()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ];

        $payment = Payment::factory()->create($usingServiceables);
        $this->assertInstanceOf(Providable::class, $payment->getProvider());
    }

    #[Test]
    public function retrieve_payment_accountable()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ];

        $payment = Payment::factory()->create($usingServiceables);
        $this->assertInstanceOf(Accountable::class, $payment->getAccount());
    }
}
