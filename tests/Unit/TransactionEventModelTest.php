<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\CheckoutStatus;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\TransactionEvent;
use Payavel\Checkout\Tests\Models\TestPayment;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Support\ServiceConfig;
use PHPUnit\Framework\Attributes\Test;

class TransactionEventModelTest extends TestCase
{
    #[Test]
    public function retrieve_transaction_event_payment()
    {
        $transactionEventWithPayment = TransactionEvent::factory()->create(['status_code' => CheckoutStatus::AUTHORIZED]);
        $this->assertInstanceOf(Payment::class, $transactionEventWithPayment->payment);

        ServiceConfig::set('checkout', 'models.' . Payment::class, TestPayment::class);
        $transactionEventWithOverriddenPayment = TransactionEvent::factory()->create(['status_code' => CheckoutStatus::AUTHORIZED]);
        $this->assertInstanceOf(TestPayment::class, $transactionEventWithOverriddenPayment->payment);
    }

    #[Test]
    public function retrieve_transaction_event_transactionable()
    {
        $transactionEvent = TransactionEvent::factory()->create(['status_code' => CheckoutStatus::AUTHORIZED]);
        $this->assertNull($transactionEvent->transactionable);

        $transactionEventWithTransactionable = TransactionEvent::factory()->for(Payment::factory(), 'transactionable')->create(['status_code' => CheckoutStatus::AUTHORIZED]);
        $this->assertInstanceOf(Payment::class, $transactionEventWithTransactionable->transactionable);

        ServiceConfig::set('checkout', 'models.' . Payment::class, TestPayment::class);
        $transactionEventWithOverriddenTransactionable = TransactionEvent::factory()->create(['status_code' => CheckoutStatus::AUTHORIZED]);
        $transactionEventWithOverriddenTransactionable->transactionable()->associate(transform(Payment::factory()->create(), fn ($payment) => TestPayment::find($payment->id)));
        $this->assertInstanceOf(TestPayment::class, $transactionEventWithOverriddenTransactionable->transactionable);
    }
}
