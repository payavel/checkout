<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\Models\PaymentInstrument;
use Payavel\Checkout\Models\PaymentRail;
use Payavel\Checkout\Models\PaymentType;
use Payavel\Checkout\Models\Wallet;
use Payavel\Checkout\Tests\Models\TestPaymentInstrument;
use Payavel\Checkout\Tests\Models\TestPaymentRail;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Fluent\ServiceConfig;
use Payavel\Orchestration\Tests\Contracts\CreatesServiceables;
use PHPUnit\Framework\Attributes\Test;

abstract class TestPaymentTypeModel extends TestCase implements CreatesServiceables
{
    #[Test]
    public function retrieve_payment_type_rails()
    {
        $paymentType = PaymentType::factory()->create();
        $this->assertEmpty($paymentType->rails);

        $paymentTypeWith2Rails = PaymentType::factory()->hasRails(2)->create();
        $this->assertCount(2, $paymentTypeWith2Rails->rails);
        $this->assertContainsOnlyInstancesOf(PaymentRail::class, $paymentTypeWith2Rails->rails);

        ServiceConfig::find('checkout')->set('models.' . PaymentRail::class, TestPaymentRail::class);
        $paymentTypeWith3OverriddenRails = PaymentType::factory()->hasRails(3)->create();
        $this->assertCount(3, $paymentTypeWith3OverriddenRails->rails);
        $this->assertContainsOnlyInstancesOf(TestPaymentRail::class, $paymentTypeWith3OverriddenRails->rails);
    }

    #[Test]
    public function retrieve_payment_type_instruments()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ]);

        $paymentType = PaymentType::factory()->create();
        $this->assertEmpty($paymentType->instruments);

        $paymentTypeWith2Instruments = PaymentType::factory()->has(PaymentInstrument::factory()->count(2)->for($wallet), 'instruments')->create();
        $this->assertCount(2, $paymentTypeWith2Instruments->instruments);
        $this->assertContainsOnlyInstancesOf(PaymentInstrument::class, $paymentTypeWith2Instruments->instruments);

        ServiceConfig::find('checkout')->set('models.' . PaymentInstrument::class, TestPaymentInstrument::class);
        $paymentTypeWith3OverriddenInstruments = PaymentType::factory()->has(PaymentInstrument::factory()->count(3)->for($wallet), 'instruments')->create();
        $this->assertCount(3, $paymentTypeWith3OverriddenInstruments->instruments);
        $this->assertContainsOnlyInstancesOf(TestPaymentInstrument::class, $paymentTypeWith3OverriddenInstruments->instruments);
    }
}
