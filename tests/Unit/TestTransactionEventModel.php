<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\CheckoutStatus;
use Payavel\Checkout\Models\Dispute;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\Refund;
use Payavel\Checkout\Models\TransactionEvent;
use Payavel\Checkout\Tests\Models\TestDispute;
use Payavel\Checkout\Tests\Models\TestPayment;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Tests\Contracts\CreatesServiceables;
use PHPUnit\Framework\Attributes\Test;

abstract class TestTransactionEventModel extends TestCase implements CreatesServiceables
{
    #[Test]
    public function retrieve_transaction_event_payment()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutConfig)->getId(),
            'account_id' => $this->createAccount($this->checkoutConfig)->getId(),
        ];

        $transactionEventWithPayment = TransactionEvent::factory()->for(Payment::factory()->create($usingServiceables))->create(['status_code' => CheckoutStatus::AUTHORIZED]);
        $this->assertInstanceOf(Payment::class, $transactionEventWithPayment->payment);

        $this->checkoutConfig->set('models.' . Payment::class, TestPayment::class);
        $transactionEventWithOverriddenPayment = TransactionEvent::factory()->for(Payment::factory()->create($usingServiceables))->create(['status_code' => CheckoutStatus::AUTHORIZED]);
        $this->assertInstanceOf(TestPayment::class, $transactionEventWithOverriddenPayment->payment);
    }

    #[Test]
    public function retrieve_transaction_event_transactionable()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutConfig)->getId(),
            'account_id' => $this->createAccount($this->checkoutConfig)->getId(),
        ];

        $transactionEvent = TransactionEvent::factory()->for(Payment::factory()->create($usingServiceables))->create(['status_code' => CheckoutStatus::AUTHORIZED]);
        $this->assertNull($transactionEvent->transactionable);

        $transactionEventWithTransactionable = TransactionEvent::factory()->for($paymentForTransactionEventWithTransactionable = Payment::factory()->create($usingServiceables))->for(Refund::factory()->for($paymentForTransactionEventWithTransactionable)->create(), 'transactionable')->create(['status_code' => CheckoutStatus::AUTHORIZED]);
        $this->assertInstanceOf(Refund::class, $transactionEventWithTransactionable->transactionable);

        $this->checkoutConfig->set('models.' . Dispute::class, TestDispute::class);
        $transactionEventWithOverriddenTransactionable = TransactionEvent::factory()->for($paymentForTransactionEventWithOverriddenTransactionable = Payment::factory()->create($usingServiceables))->create(['status_code' => CheckoutStatus::AUTHORIZED]);
        $transactionEventWithOverriddenTransactionable->transactionable()->associate(transform(Dispute::factory()->for($paymentForTransactionEventWithOverriddenTransactionable)->create(), fn ($dispute) => TestDispute::find($dispute->id)));
        $this->assertInstanceOf(TestDispute::class, $transactionEventWithOverriddenTransactionable->transactionable);
    }
}
