<?php

namespace Payavel\Checkout\Tests\Unit\Models;

use Payavel\Checkout\Models\PaymentInstrument;
use Payavel\Checkout\Models\PaymentRail;
use Payavel\Checkout\Models\PaymentType;
use Payavel\Checkout\Tests\Models\TestPaymentInstrument;
use Payavel\Checkout\Tests\Models\TestPaymentRail;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Support\ServiceConfig;
use PHPUnit\Framework\Attributes\Test;

class PaymentTypeTest extends TestCase
{
    #[Test]
    public function retrieve_payment_type_rails()
    {
        $paymentType = PaymentType::factory()->create();
        $this->assertEmpty($paymentType->rails);

        $paymentTypeWith2Rails = PaymentType::factory()->hasRails(2)->create();
        $this->assertCount(2, $paymentTypeWith2Rails->rails);
        $this->assertContainsOnlyInstancesOf(PaymentRail::class, $paymentTypeWith2Rails->rails);

        ServiceConfig::set('checkout', 'models.' . PaymentRail::class, TestPaymentRail::class);
        $paymentTypeWith3OverriddenRails = PaymentType::factory()->hasRails(3)->create();
        $this->assertCount(3, $paymentTypeWith3OverriddenRails->rails);
        $this->assertContainsOnlyInstancesOf(TestPaymentRail::class, $paymentTypeWith3OverriddenRails->rails);
    }

    #[Test]
    public function retrieve_payment_type_instruments()
    {
        $paymentType = PaymentType::factory()->create();
        $this->assertEmpty($paymentType->instruments);

        $paymentTypeWith2Instruments = PaymentType::factory()->hasInstruments(2)->create();
        $this->assertCount(2, $paymentTypeWith2Instruments->instruments);
        $this->assertContainsOnlyInstancesOf(PaymentInstrument::class, $paymentTypeWith2Instruments->instruments);

        ServiceConfig::set('checkout', 'models.' . PaymentInstrument::class, TestPaymentInstrument::class);
        $paymentTypeWith3OverriddenInstruments = PaymentType::factory()->hasInstruments(3)->create();
        $this->assertCount(3, $paymentTypeWith3OverriddenInstruments->instruments);
        $this->assertContainsOnlyInstancesOf(TestPaymentInstrument::class, $paymentTypeWith3OverriddenInstruments->instruments);
    }
}
