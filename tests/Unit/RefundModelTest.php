<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\Refund;
use Payavel\Checkout\Models\TransactionEvent;
use Payavel\Checkout\Tests\Models\TestPayment;
use Payavel\Checkout\Tests\Models\TestTransactionEvent;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Support\ServiceConfig;
use PHPUnit\Framework\Attributes\Test;

class RefundModelTest extends TestCase
{
    #[Test]
    public function retrieve_refund_payment()
    {
        $refundWithPayment = Refund::factory()->create();
        $this->assertInstanceOf(Payment::class, $refundWithPayment->payment);

        ServiceConfig::set('checkout', 'models.' . Payment::class, TestPayment::class);
        $refundWithOverriddenPayment = Refund::factory()->create();
        $this->assertInstanceOf(TestPayment::class, $refundWithOverriddenPayment->payment);
    }

    #[Test]
    public function retrieve_refund_transaction_events()
    {
        $refund = Refund::factory()->create();
        $this->assertEmpty($refund->transactionEvents);

        $refundWith2TransactionEvents = Refund::factory()->hasTransactionEvents(2)->create();
        $this->assertCount(2, $refundWith2TransactionEvents->transactionEvents);
        $this->assertContainsOnlyInstancesOf(TransactionEvent::class, $refundWith2TransactionEvents->transactionEvents);

        ServiceConfig::set('checkout', 'models.' . TransactionEvent::class, TestTransactionEvent::class);
        $refundWith3OverriddenTransactionEvents = Refund::factory()->hasTransactionEvents(3)->create();
        $this->assertCount(3, $refundWith3OverriddenTransactionEvents->transactionEvents);
        $this->assertContainsOnlyInstancesOf(TestTransactionEvent::class, $refundWith3OverriddenTransactionEvents->transactionEvents);
    }
}
