<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\Facades\Checkout;
use Payavel\Checkout\Models\PaymentInstrument;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\Wallet;
use Payavel\Checkout\CheckoutRequest;
use Payavel\Checkout\CheckoutResponse;
use Payavel\Checkout\CheckoutStatus;
use Payavel\Checkout\Tests\TestCase;
use Payavel\Checkout\Tests\User;
use Payavel\Orchestration\Tests\Contracts\CreatesServiceables;
use PHPUnit\Framework\Attributes\Test;

abstract class TestCheckoutGateway extends TestCase implements CreatesServiceables
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $provider = $this->createProvider($this->checkoutConfig, [
            'gateway' => TestCheckoutRequest::class,
        ]);

        $account = $this->createAccount($this->checkoutConfig);

        $this->linkAccountToProvider($account, $provider);

        $this->setDefaultsForService($this->checkoutConfig, $account, $provider);
    }

    #[Test]
    public function get_wallet_method_returns_configured_response()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => Checkout::getProvider()->getId(),
            'account_id' => Checkout::getAccount()->getId(),
        ]);

        $response = Checkout::getWallet($wallet);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('getWallet', $response->data['requestMethod']);
    }

    #[Test]
    public function get_payment_instrument_method_returns_configured_response()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => Checkout::getProvider()->getId(),
            'account_id' => Checkout::getAccount()->getId(),
        ]);

        $paymentInstrument = PaymentInstrument::factory()->create([
            'wallet_id' => $wallet->id,
        ]);

        $response = Checkout::getPaymentInstrument($paymentInstrument);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('getPaymentInstrument', $response->data['requestMethod']);
    }

    #[Test]
    public function tokenize_payment_instrument_method_returns_configured_response()
    {
        $user = User::factory()->create();

        $response = Checkout::tokenizePaymentInstrument($user, []);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('tokenizePaymentInstrument', $response->data['requestMethod']);
    }

    #[Test]
    public function update_payment_instrument_method_returns_configured_response()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => Checkout::getProvider()->getId(),
            'account_id' => Checkout::getAccount()->getId(),
        ]);

        $paymentInstrument = PaymentInstrument::factory()->create([
            'wallet_id' => $wallet->id,
        ]);

        $response = Checkout::updatePaymentInstrument($paymentInstrument, []);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('updatePaymentInstrument', $response->data['requestMethod']);
    }

    #[Test]
    public function delete_payment_instrument_method_returns_configured_response()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => Checkout::getProvider()->getId(),
            'account_id' => Checkout::getAccount()->getId(),
        ]);

        $paymentInstrument = PaymentInstrument::factory()->create([
            'wallet_id' => $wallet->id,
        ]);

        $response = Checkout::deletePaymentInstrument($paymentInstrument);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('deletePaymentInstrument', $response->data['requestMethod']);
    }

    #[Test]
    public function authorize_method_returns_configured_response()
    {
        $response = Checkout::authorize([]);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('authorize', $response->data['requestMethod']);
    }

    #[Test]
    public function capture_method_returns_configured_response()
    {
        $payment = Payment::factory()->create([
            'provider_id' => Checkout::getProvider()->getId(),
            'account_id' => Checkout::getAccount()->getId(),
        ]);

        $response = Checkout::capture($payment);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('capture', $response->data['requestMethod']);
    }

    #[Test]
    public function get_transaction_method_returns_configured_response()
    {
        $payment = Payment::factory()->create([
            'provider_id' => Checkout::getProvider()->getId(),
            'account_id' => Checkout::getAccount()->getId(),
        ]);

        $response = Checkout::getTransaction($payment);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('getTransaction', $response->data['requestMethod']);
    }

    #[Test]
    public function void_method_returns_configured_response()
    {
        $payment = Payment::factory()->create([
            'provider_id' => Checkout::getProvider()->getId(),
            'account_id' => Checkout::getAccount()->getId(),
        ]);

        $response = Checkout::void($payment);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('void', $response->data['requestMethod']);
    }

    #[Test]
    public function refund_method_returns_configured_response()
    {
        $payment = Payment::factory()->create([
            'provider_id' => Checkout::getProvider()->getId(),
            'account_id' => Checkout::getAccount()->getId(),
        ]);

        $response = Checkout::refund($payment);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('refund', $response->data['requestMethod']);
    }

    /**
     * Assert the response is configured automatically.
     *
     * @param string $requestMethod
     * @param \Payavel\Checkout\CheckoutResponse $response
     * @return void
     */
    protected function assertResponseIsConfigured(CheckoutResponse $response)
    {
        $this->assertEquals(Checkout::getProvider()->getId(), $response->provider->id);
        $this->assertEquals(Checkout::getAccount()->getId(), $response->account->id);
    }
}

class TestCheckoutRequest extends CheckoutRequest
{
    public function getWallet(Wallet $wallet)
    {
        return new TestCheckoutResponse([]);
    }

    public function getPaymentInstrument(PaymentInstrument $paymentInstrument)
    {
        return new TestCheckoutResponse([]);
    }

    public function tokenizePaymentInstrument(Billable $billable, $data)
    {
        return new TestCheckoutResponse([]);
    }

    public function updatePaymentInstrument(PaymentInstrument $paymentInstrument, $data)
    {
        return new TestCheckoutResponse([]);
    }

    public function deletePaymentInstrument(PaymentInstrument $paymentInstrument)
    {
        return new TestCheckoutResponse([]);
    }

    public function authorize($data, Billable $billable = null)
    {
        return new TestCheckoutResponse([]);
    }

    public function capture(Payment $payment, $data = [])
    {
        return new TestCheckoutResponse([]);
    }

    public function getTransaction(Payment $transaction)
    {
        return new TestCheckoutResponse([]);
    }

    public function void(Payment $payment, $data = [])
    {
        return new TestCheckoutResponse([]);
    }

    public function refund(Payment $payment, $data = [])
    {
        return new TestCheckoutResponse([]);
    }
}

class TestCheckoutResponse extends CheckoutResponse
{
    public function getWalletResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function getPaymentInstrumentResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function tokenizePaymentInstrumentResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function updatePaymentInstrumentResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function deletePaymentInstrumentResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function authorizeResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function captureResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function getTransactionResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function voidResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function refundResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function getStatusCode()
    {
        return CheckoutStatus::AUTHORIZED;
    }
}
