<?php

namespace Payavel\Checkout\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Payavel\Checkout\Models\PaymentTransaction;
use Payavel\Checkout\PaymentResponse;
use Payavel\Checkout\Tests\GatewayTestCase;

class TestPaymentTransactionRequestsTrait extends GatewayTestCase
{
    /** @test */
    public function fetch_payment_transaction_request_auto_configures_payment_gateway()
    {
        $paymentTransaction = $this->createPaymentTransaction();

        $response = $paymentTransaction->fetch();

        $this->assertModelMatchesResponse($paymentTransaction, $response);
        $this->assertEquals('getTransaction', $response->data['requestMethod']);
    }

    /** @test */
    public function void_payment_transaction_request_auto_configures_payment_gateway()
    {
        $paymentTransaction = $this->createPaymentTransaction();

        $response = $paymentTransaction->void([]);

        $this->assertModelMatchesResponse($paymentTransaction, $response);
        $this->assertEquals('void', $response->data['requestMethod']);
    }

    /** @test */
    public function refund_payment_transaction_request_auto_configures_payment_gateway()
    {
        $paymentTransaction = $this->createPaymentTransaction();

        $response = $paymentTransaction->refund();

        $this->assertModelMatchesResponse($paymentTransaction, $response);
        $this->assertEquals('refund', $response->data['requestMethod']);
    }

    private function createPaymentTransaction()
    {
        return PaymentTransaction::factory()->create([
            'provider_id' => $this->provider,
            'merchant_id' => $this->merchant,
        ]);
    }

    /**
     * Assert the response provider & merchant matches the model's configuration.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param \Payavel\Checkout\PaymentResponse $response
     * @return void
     */
    protected function assertModelMatchesResponse(Model $model, PaymentResponse $response)
    {
        $this->assertEquals($model->provider_id, $response->provider->id);
        $this->assertEquals($model->merchant_id, $response->merchant->id);
    }
}
