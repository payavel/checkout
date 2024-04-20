<?php

namespace Payavel\Checkout\Tests\Unit;

use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\Facades\Checkout;
use Payavel\Checkout\Models\PaymentMethod;
use Payavel\Checkout\Models\PaymentTransaction;
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

        $provider = $this->createProvider($this->checkoutService, [
            'gateway' => TestCheckoutRequest::class,
        ]);

        $account = $this->createAccount($this->checkoutService);

        $this->linkAccountToProvider($account, $provider);

        $this->setDefaultsForService($this->checkoutService, $account, $provider);
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
    public function get_payment_method_method_returns_configured_response()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => Checkout::getProvider()->getId(),
            'account_id' => Checkout::getAccount()->getId(),
        ]);

        $paymentMethod = PaymentMethod::factory()->create([
            'wallet_id' => $wallet->id,
        ]);

        $response = Checkout::getPaymentMethod($paymentMethod);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('getPaymentMethod', $response->data['requestMethod']);
    }

    #[Test]
    public function tokenize_payment_method_method_returns_configured_response()
    {
        $user = User::factory()->create();

        $response = Checkout::tokenizePaymentMethod($user, []);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('tokenizePaymentMethod', $response->data['requestMethod']);
    }

    #[Test]
    public function update_payment_method_method_returns_configured_response()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => Checkout::getProvider()->getId(),
            'account_id' => Checkout::getAccount()->getId(),
        ]);

        $paymentMethod = PaymentMethod::factory()->create([
            'wallet_id' => $wallet->id,
        ]);

        $response = Checkout::updatePaymentMethod($paymentMethod, []);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('updatePaymentMethod', $response->data['requestMethod']);
    }

    #[Test]
    public function delete_payment_method_method_returns_configured_response()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => Checkout::getProvider()->getId(),
            'account_id' => Checkout::getAccount()->getId(),
        ]);

        $paymentMethod = PaymentMethod::factory()->create([
            'wallet_id' => $wallet->id,
        ]);

        $response = Checkout::deletePaymentMethod($paymentMethod);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('deletePaymentMethod', $response->data['requestMethod']);
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
        $transaction = PaymentTransaction::factory()->create([
            'provider_id' => Checkout::getProvider()->getId(),
            'account_id' => Checkout::getAccount()->getId(),
        ]);

        $response = Checkout::capture($transaction);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('capture', $response->data['requestMethod']);
    }

    #[Test]
    public function get_transaction_method_returns_configured_response()
    {
        $transaction = PaymentTransaction::factory()->create([
            'provider_id' => Checkout::getProvider()->getId(),
            'account_id' => Checkout::getAccount()->getId(),
        ]);

        $response = Checkout::getTransaction($transaction);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('getTransaction', $response->data['requestMethod']);
    }

    #[Test]
    public function void_method_returns_configured_response()
    {
        $transaction = PaymentTransaction::factory()->create([
            'provider_id' => Checkout::getProvider()->getId(),
            'account_id' => Checkout::getAccount()->getId(),
        ]);

        $response = Checkout::void($transaction);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('void', $response->data['requestMethod']);
    }

    #[Test]
    public function refund_method_returns_configured_response()
    {
        $transaction = PaymentTransaction::factory()->create([
            'provider_id' => Checkout::getProvider()->getId(),
            'account_id' => Checkout::getAccount()->getId(),
        ]);

        $response = Checkout::refund($transaction);

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

    public function getPaymentMethod(PaymentMethod $paymentMethod)
    {
        return new TestCheckoutResponse([]);
    }

    public function tokenizePaymentMethod(Billable $billable, $data)
    {
        return new TestCheckoutResponse([]);
    }

    public function updatePaymentMethod(PaymentMethod $paymentMethod, $data)
    {
        return new TestCheckoutResponse([]);
    }

    public function deletePaymentMethod(PaymentMethod $paymentMethod)
    {
        return new TestCheckoutResponse([]);
    }

    public function authorize($data, Billable $billable = null)
    {
        return new TestCheckoutResponse([]);
    }

    public function capture(PaymentTransaction $transaction, $data = [])
    {
        return new TestCheckoutResponse([]);
    }

    public function getTransaction(PaymentTransaction $transaction)
    {
        return new TestCheckoutResponse([]);
    }

    public function void(PaymentTransaction $paymentTransaction, $data = [])
    {
        return new TestCheckoutResponse([]);
    }

    public function refund(PaymentTransaction $paymentTransaction, $data = [])
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

    public function getPaymentMethodResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function tokenizePaymentMethodResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function updatePaymentMethodResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function deletePaymentMethodResponse()
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
