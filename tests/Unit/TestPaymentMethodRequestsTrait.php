<?php

namespace Payavel\Checkout\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Payavel\Checkout\Models\PaymentMethod;
use Payavel\Checkout\Models\Wallet;
use Payavel\Checkout\PaymentResponse;
use Payavel\Checkout\Tests\GatewayTestCase;

class TestPaymentMethodRequestsTrait extends GatewayTestCase
{
    /** @test */
    public function fetch_payment_method_request_auto_configures_payment_gateway()
    {
        $wallet = $this->createWallet();

        $paymentMethod = PaymentMethod::factory()->create([
            'wallet_id' => $wallet->id,
        ]);

        $response = $paymentMethod->fetch();

        $this->assertModelMatchesResponse($paymentMethod, $response);
        $this->assertEquals('getPaymentMethod', $response->data['requestMethod']);
    }

    /** @test */
    public function patch_payment_method_request_auto_configures_payment_gateway()
    {
        $wallet = $this->createWallet();

        $paymentMethod = PaymentMethod::factory()->create([
            'wallet_id' => $wallet->id,
        ]);

        $response = $paymentMethod->patch([]);

        $this->assertModelMatchesResponse($paymentMethod, $response);
        $this->assertEquals('updatePaymentMethod', $response->data['requestMethod']);
    }

    /** @test */
    public function disable_payment_method_request_auto_configures_payment_gateway()
    {
        $wallet = $this->createWallet();

        $paymentMethod = PaymentMethod::factory()->create([
            'wallet_id' => $wallet->id,
        ]);

        $response = $paymentMethod->disable();

        $this->assertModelMatchesResponse($paymentMethod, $response);
        $this->assertEquals('deletePaymentMethod', $response->data['requestMethod']);
    }

    private function createWallet()
    {
        return Wallet::factory()->create([
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