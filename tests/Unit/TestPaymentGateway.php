<?php

namespace Payavel\Checkout\Tests\Unit;

use Exception;
use Payavel\Checkout\Facades\Payment;
use Payavel\Checkout\Models\PaymentMethod;
use Payavel\Checkout\Models\PaymentTransaction;
use Payavel\Checkout\Models\Wallet;
use Payavel\Checkout\PaymentResponse;
use Payavel\Checkout\Tests\AlternativePaymentResponse;
use Payavel\Checkout\Tests\GatewayTestCase;
use Payavel\Checkout\Tests\TestPaymentResponse;
use Payavel\Checkout\Tests\User;
use PHPUnit\Framework\Attributes\Test;

class TestPaymentGateway extends GatewayTestCase
{
    #[Test]
    public function get_wallet_method_returns_configured_response()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => Payment::getProvider()->getId(),
            'merchant_id' => Payment::getMerchant()->getId(),
        ]);

        $response = Payment::getWallet($wallet);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('getWallet', $response->data['requestMethod']);
    }

    #[Test]
    public function get_payment_method_method_returns_configured_response()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => Payment::getProvider()->getId(),
            'merchant_id' => Payment::getMerchant()->getId(),
        ]);

        $paymentMethod = PaymentMethod::factory()->create([
            'wallet_id' => $wallet->id,
        ]);

        $response = Payment::getPaymentMethod($paymentMethod);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('getPaymentMethod', $response->data['requestMethod']);
    }

    #[Test]
    public function tokenize_payment_method_method_returns_configured_response()
    {
        $user = User::factory()->create();

        $response = Payment::tokenizePaymentMethod($user, []);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('tokenizePaymentMethod', $response->data['requestMethod']);
    }

    #[Test]
    public function update_payment_method_method_returns_configured_response()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => Payment::getProvider()->getId(),
            'merchant_id' => Payment::getMerchant()->getId(),
        ]);

        $paymentMethod = PaymentMethod::factory()->create([
            'wallet_id' => $wallet->id,
        ]);

        $response = Payment::updatePaymentMethod($paymentMethod, []);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('updatePaymentMethod', $response->data['requestMethod']);
    }

    #[Test]
    public function delete_payment_method_method_returns_configured_response()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => Payment::getProvider()->getId(),
            'merchant_id' => Payment::getMerchant()->getId(),
        ]);

        $paymentMethod = PaymentMethod::factory()->create([
            'wallet_id' => $wallet->id,
        ]);

        $response = Payment::deletePaymentMethod($paymentMethod);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('deletePaymentMethod', $response->data['requestMethod']);
    }

    #[Test]
    public function authorize_method_returns_configured_response()
    {
        $response = Payment::authorize([]);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('authorize', $response->data['requestMethod']);
    }

    #[Test]
    public function capture_method_returns_configured_response()
    {
        $transaction = PaymentTransaction::factory()->create([
            'provider_id' => Payment::getProvider()->getId(),
            'merchant_id' => Payment::getMerchant()->getId(),
        ]);

        $response = Payment::capture($transaction);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('capture', $response->data['requestMethod']);
    }

    #[Test]
    public function get_transaction_method_returns_configured_response()
    {
        $transaction = PaymentTransaction::factory()->create([
            'provider_id' => Payment::getProvider()->getId(),
            'merchant_id' => Payment::getMerchant()->getId(),
        ]);

        $response = Payment::getTransaction($transaction);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('getTransaction', $response->data['requestMethod']);
    }

    #[Test]
    public function void_method_returns_configured_response()
    {
        $transaction = PaymentTransaction::factory()->create([
            'provider_id' => Payment::getProvider()->getId(),
            'merchant_id' => Payment::getMerchant()->getId(),
        ]);

        $response = Payment::void($transaction);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('void', $response->data['requestMethod']);
    }

    #[Test]
    public function refund_method_returns_configured_response()
    {
        $transaction = PaymentTransaction::factory()->create([
            'provider_id' => Payment::getProvider()->getId(),
            'merchant_id' => Payment::getMerchant()->getId(),
        ]);

        $response = Payment::refund($transaction);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('refund', $response->data['requestMethod']);
    }

    /**
     * Assert the response is configured automatically.
     *
     * @param string $requestMethod
     * @param \Payavel\Checkout\PaymentResponse $response
     * @return void
     */
    protected function assertResponseIsConfigured(PaymentResponse $response)
    {
        $this->assertEquals(Payment::getProvider()->getId(), $response->provider->id);
        $this->assertEquals(Payment::getMerchant()->getId(), $response->merchant->id);
    }
}
