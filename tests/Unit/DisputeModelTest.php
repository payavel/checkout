<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\Models\Dispute;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\TransactionEvent;
use Payavel\Checkout\Tests\Models\TestAccount;
use Payavel\Checkout\Tests\Models\TestPayment;
use Payavel\Checkout\Tests\Models\TestProvider;
use Payavel\Checkout\Tests\Models\TestTransactionEvent;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Support\ServiceConfig;
use PHPUnit\Framework\Attributes\Test;

class DisputeModelTest extends TestCase
{
    #[Test]
    public function retrieve_dispute_provider()
    {
        $disputeWithProvider = Dispute::factory()->create();
        $this->assertInstanceOf(Provider::class, $disputeWithProvider->provider);

        ServiceConfig::set('checkout', 'models.' . Provider::class, TestProvider::class);
        $disputeWithOverriddenProvider = Dispute::factory()->create();
        $this->assertInstanceOf(TestProvider::class, $disputeWithOverriddenProvider->provider);
    }

    #[Test]
    public function retrieve_dispute_account()
    {
        $disputeWithAccount = Dispute::factory()->create();
        $this->assertInstanceOf(Account::class, $disputeWithAccount->account);

        ServiceConfig::set('checkout', 'models.' . Account::class, TestAccount::class);
        $disputeWithOverriddenAccount = Dispute::factory()->create();
        $this->assertInstanceOf(TestAccount::class, $disputeWithOverriddenAccount->account);
    }

    #[Test]
    public function retrieve_dispute_payment()
    {
        $disputeWithPayment = Dispute::factory()->create();
        $this->assertInstanceOf(Payment::class, $disputeWithPayment->payment);

        ServiceConfig::set('checkout', 'models.' . Payment::class, TestPayment::class);
        $disputeWithOverriddenPayment = Dispute::factory()->create();
        $this->assertInstanceOf(TestPayment::class, $disputeWithOverriddenPayment->payment);
    }

    #[Test]
    public function retrieve_dispute_transaction_events()
    {
        $dispute = Dispute::factory()->create();
        $this->assertEmpty($dispute->transactionEvents);

        $disputeWith2TransactionEvents = Dispute::factory()->hasTransactionEvents(2)->create();
        $this->assertCount(2, $disputeWith2TransactionEvents->transactionEvents);
        $this->assertContainsOnlyInstancesOf(TransactionEvent::class, $disputeWith2TransactionEvents->transactionEvents);

        ServiceConfig::set('checkout', 'models.' . TransactionEvent::class, TestTransactionEvent::class);
        $disputeWith3OverriddenTransactionEvents = Dispute::factory()->hasTransactionEvents(3)->create();
        $this->assertCount(3, $disputeWith3OverriddenTransactionEvents->transactionEvents);
        $this->assertContainsOnlyInstancesOf(TestTransactionEvent::class, $disputeWith3OverriddenTransactionEvents->transactionEvents);
    }
}
