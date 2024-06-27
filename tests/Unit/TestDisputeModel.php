<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\Models\Dispute;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\TransactionEvent;
use Payavel\Checkout\Tests\Models\TestPayment;
use Payavel\Checkout\Tests\Models\TestTransactionEvent;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Fluent\ServiceConfig;
use Payavel\Orchestration\Tests\Contracts\CreatesServiceables;
use PHPUnit\Framework\Attributes\Test;

abstract class TestDisputeModel extends TestCase implements CreatesServiceables
{
    #[Test]
    public function retrieve_dispute_payment()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutConfig)->getId(),
            'account_id' => $this->createAccount($this->checkoutConfig)->getID(),
        ];

        $disputeWithPayment = Dispute::factory()->for(Payment::factory()->create($usingServiceables))->create();
        $this->assertInstanceOf(Payment::class, $disputeWithPayment->payment);

        ServiceConfig::find('checkout')->set('models.' . Payment::class, TestPayment::class);
        $disputeWithOverriddenPayment = Dispute::factory()->for(Payment::factory()->create($usingServiceables))->create();
        $this->assertInstanceOf(TestPayment::class, $disputeWithOverriddenPayment->payment);
    }

    #[Test]
    public function retrieve_dispute_transaction_events()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutConfig)->getId(),
            'account_id' => $this->createAccount($this->checkoutConfig)->getID(),
        ];

        $dispute = Dispute::factory()->for(Payment::factory()->create($usingServiceables))->create();
        $this->assertEmpty($dispute->transactionEvents);

        $disputeWith2TransactionEvents = Dispute::factory()->for($paymentForDisputeWith2TransactionEvents = Payment::factory()->create($usingServiceables))->hasTransactionEvents(2, ['payment_id' => $paymentForDisputeWith2TransactionEvents->id])->create();
        $this->assertCount(2, $disputeWith2TransactionEvents->transactionEvents);
        $this->assertContainsOnlyInstancesOf(TransactionEvent::class, $disputeWith2TransactionEvents->transactionEvents);

        ServiceConfig::find('checkout')->set('models.' . TransactionEvent::class, TestTransactionEvent::class);
        $disputeWith3OverriddenTransactionEvents = Dispute::factory()->for($paymentForDisputeWith3TransactionEvents = Payment::factory()->create($usingServiceables))->hasTransactionEvents(3, ['payment_id' => $paymentForDisputeWith3TransactionEvents->id])->create();
        $this->assertCount(3, $disputeWith3OverriddenTransactionEvents->transactionEvents);
        $this->assertContainsOnlyInstancesOf(TestTransactionEvent::class, $disputeWith3OverriddenTransactionEvents->transactionEvents);
    }
}
