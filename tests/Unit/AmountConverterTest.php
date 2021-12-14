<?php

namespace rkujawa\LaravelPaymentGateway\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use rkujawa\LaravelPaymentGateway\Models\PaymentMethod;
use rkujawa\LaravelPaymentGateway\Tests\App\Models\PaymentRefund;
use rkujawa\LaravelPaymentGateway\Tests\App\Models\PaymentTransaction;
use rkujawa\LaravelPaymentGateway\Tests\TestCase;

class AmountConverterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function creating_a_transaction_using_a_dollar_amount_sets_amount_cents_attribute()
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $transaction = PaymentTransaction::create([
            'provider_id' => $paymentMethod->provider->id,
            'reference_id' => $this->faker->uuid(),
            'amount' => 99.99,
            'currency' => 'USD',
            'payment_method_id' => $paymentMethod->id,
            'status_code' => 69, // TODO: Determine the status codes.
            'payload' => [],
            'references' => [
                'environment' => 'testing',
            ],
        ]);

        $this->assertEquals($transaction->amount_cents, 9999);
        $this->assertEquals($transaction->amount, 99.99);
    }

    /** @test */
    public function creating_a_full_refund_from_an_existing_transaction_sets_the_amount_correctly()
    {
        $transaction = PaymentTransaction::factory()->create();

        $refund = PaymentRefund::create([
            'reference_id' => $this->faker->uuid(),
            'transaction_id' => $transaction->id,
            'amount_cents' => $transaction->amount_cents,
            'currency' => 'USD',
            'type' => $this->faker->randomElement([PaymentRefund::VOID, PaymentRefund::REFUND]),
            'status_code' => 69, // TODO: Determine the status codes.
            'payload' => [],
        ]);

        $this->assertEquals($refund->amount_cents, $transaction->amount_cents);
        $this->assertEquals($refund->amount, $transaction->amount);
    }
}