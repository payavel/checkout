<?php

namespace Payavel\Checkout\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Payavel\Checkout\Models\PaymentMethod;
use Payavel\Checkout\Models\Wallet;
use Payavel\Checkout\PaymentResponse;
use Payavel\Checkout\Tests\GatewayTestCase;

class TestWalletRequestsTrait extends GatewayTestCase
{
    /** @test */
    public function wallet_requests_auto_configure_payment_gateway()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => $this->provider,
            'merchant_id' => $this->merchant,
        ]);

        $response = $wallet->fetch();

        $this->assertModelMatchesResponse($wallet, $response);
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