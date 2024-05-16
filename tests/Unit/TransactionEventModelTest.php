<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\Models\Dispute;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\Refund;
use Payavel\Checkout\Models\TransactionEvent;
use Payavel\Checkout\Tests\Models\TestDispute;
use Payavel\Checkout\Tests\Models\TestPayment;
use Payavel\Checkout\Tests\Models\TestRefund;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Support\ServiceConfig;
use PHPUnit\Framework\Attributes\Test;

class TransactionEventModelTest extends TestCase
{
    #[Test]
    public function retrieve_transaction_event_payment()
    {
        $transactionEventWithPayment = TransactionEvent::factory()->create();
        $this->assertInstanceOf(Payment::class, $transactionEventWithPayment->payment);

        ServiceConfig::set('checkout', 'models.' . Payment::class, TestPayment::class);
        $transactionEventWithOverriddenPayment = TransactionEvent::factory()->create();
        $this->assertInstanceOf(TestPayment::class, $transactionEventWithOverriddenPayment->payment);
    }

    #[Test]
    public function retrieve_transaction_event_transactionable()
    {
        $transactionEvent = TransactionEvent::factory()->create();
        $this->assertNull($transactionEvent->transactionable);

        $transactionables = [
            Payment::class => TestPayment::class,
            Refund::class => TestRefund::class,
            Dispute::class => TestDispute::class,
        ];

        $randomTransactionable = $this->faker->randomElement(array_keys($transactionables));
        $transactionEventWithTransactionable = TransactionEvent::factory()->for($randomTransactionable::factory(), 'transactionable')->create();
        $this->assertInstanceOf($randomTransactionable, $transactionEventWithTransactionable->transactionable);

        $randomTransactionable = $this->faker->randomElement(array_keys($transactionables));
        ServiceConfig::set('checkout', 'models.' . $randomTransactionable, $transactionables[$randomTransactionable]);
        $transactionEventWithOverriddenTransactionable = TransactionEvent::factory()->for($transactionables[$randomTransactionable]::factory(), 'transactionable')->create();
        $this->assertInstanceOf($transactionables[$randomTransactionable], $transactionEventWithOverriddenTransactionable->transactionable);
    }
}
