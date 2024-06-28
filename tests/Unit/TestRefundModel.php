<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\Refund;
use Payavel\Checkout\Models\TransactionEvent;
use Payavel\Checkout\Tests\Models\TestPayment;
use Payavel\Checkout\Tests\Models\TestTransactionEvent;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\ServiceConfig;
use Payavel\Orchestration\Tests\Contracts\CreatesServiceables;
use PHPUnit\Framework\Attributes\Test;

abstract class TestRefundModel extends TestCase implements CreatesServiceables
{
    #[Test]
    public function retrieve_refund_payment()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutConfig)->getId(),
            'account_id' => $this->createAccount($this->checkoutConfig)->getId(),
        ];

        $refundWithPayment = Refund::factory()->for(Payment::factory()->create($usingServiceables))->create();
        $this->assertInstanceOf(Payment::class, $refundWithPayment->payment);

        $this->checkoutConfig->set('models.' . Payment::class, TestPayment::class);
        $refundWithOverriddenPayment = Refund::factory()->for(Payment::factory()->create($usingServiceables))->create();
        $this->assertInstanceOf(TestPayment::class, $refundWithOverriddenPayment->payment);
    }

    #[Test]
    public function retrieve_refund_transaction_events()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutConfig)->getId(),
            'account_id' => $this->createAccount($this->checkoutConfig)->getId(),
        ];

        $refund = Refund::factory()->for(Payment::factory()->create($usingServiceables))->create();
        $this->assertEmpty($refund->transactionEvents);

        $refundWith2TransactionEvents = Refund::factory()->for($paymentForRefundWith2TransactionEvents = Payment::factory()->create($usingServiceables))->hasTransactionEvents(2, ['payment_id' => $paymentForRefundWith2TransactionEvents->id])->create();
        $this->assertCount(2, $refundWith2TransactionEvents->transactionEvents);
        $this->assertContainsOnlyInstancesOf(TransactionEvent::class, $refundWith2TransactionEvents->transactionEvents);

        $this->checkoutConfig->set('models.' . TransactionEvent::class, TestTransactionEvent::class);
        $refundWith3OverriddenTransactionEvents = Refund::factory()->for($paymentForRefundWith3TransactionEvents = Payment::factory()->create($usingServiceables))->hasTransactionEvents(3, ['payment_id' => $paymentForRefundWith3TransactionEvents->id])->create();
        $this->assertCount(3, $refundWith3OverriddenTransactionEvents->transactionEvents);
        $this->assertContainsOnlyInstancesOf(TestTransactionEvent::class, $refundWith3OverriddenTransactionEvents->transactionEvents);
    }
}
