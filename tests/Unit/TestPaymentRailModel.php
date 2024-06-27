<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\PaymentRail;
use Payavel\Checkout\Models\PaymentType;
use Payavel\Checkout\Tests\Models\TestPayment;
use Payavel\Checkout\Tests\Models\TestPaymentType;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Fluent\ServiceConfig;
use Payavel\Orchestration\Tests\Contracts\CreatesServiceables;
use PHPUnit\Framework\Attributes\Test;

abstract class TestPaymentRailModel extends TestCase implements CreatesServiceables
{
    #[Test]
    public function payment_rail_generates_id_before_committing()
    {
        $parentPaymentType = PaymentType::factory()->create();
        $paymentType = PaymentType::factory()->create();

        $paymentRail = PaymentRail::create([
            'parent_type_id' => $parentPaymentType->id,
            'type_id' => $paymentType->id,
        ]);

        $this->assertEquals("{$parentPaymentType->id}:{$paymentType->id}", $paymentRail->id);
    }

    #[Test]
    public function payment_rail_generates_the_same_id_before_committing_when_parent_type_is_equal_to_type()
    {
        $paymentType = PaymentType::factory()->create();

        $paymentRail = PaymentRail::create([
            'parent_type_id' => $paymentType->id,
            'type_id' => $paymentType->id,
        ]);

        $this->assertEquals($paymentType->id, $paymentRail->id);
    }

    #[Test]
    public function retrieve_payment_rail_parent_type()
    {
        $paymentRail = PaymentRail::factory()->create();
        $this->assertInstanceOf(PaymentType::class, $paymentRail->parentType);

        ServiceConfig::find('checkout')->set('models.' . PaymentType::class, TestPaymentType::class);
        $paymentRailWithOverriddenParentType = PaymentRail::factory()->create();
        $this->assertInstanceOf(TestPaymentType::class, $paymentRailWithOverriddenParentType->parentType);
    }

    #[Test]
    public function retrieve_payment_rail_type()
    {
        $paymentRail = PaymentRail::factory()->create();
        $this->assertInstanceOf(PaymentType::class, $paymentRail->type);

        ServiceConfig::find('checkout')->set('models.' . PaymentType::class, TestPaymentType::class);
        $paymentRailWithOverriddenType = PaymentRail::factory()->create();
        $this->assertInstanceOf(TestPaymentType::class, $paymentRailWithOverriddenType->type);
    }

    #[Test]
    public function retrieve_payment_rail_payments()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ];

        $paymentRail = PaymentRail::factory()->create();
        $this->assertEmpty($paymentRail->payments);

        $paymentRailWith2Payments = PaymentRail::factory()->hasPayments(2, $usingServiceables)->create();
        $this->assertCount(2, $paymentRailWith2Payments->payments);
        $this->assertContainsOnlyInstancesOf(Payment::class, $paymentRailWith2Payments->payments);

        ServiceConfig::find('checkout')->set('models.' . Payment::class, TestPayment::class);
        $paymentRailWith3OverriddenPayments = PaymentRail::factory()->hasPayments(3, $usingServiceables)->create();
        $this->assertCount(3, $paymentRailWith3OverriddenPayments->payments);
        $this->assertContainsOnlyInstancesOf(TestPayment::class, $paymentRailWith3OverriddenPayments->payments);
    }
}
