<?php

namespace Payavel\Checkout\Tests;

use Illuminate\Support\Str;
use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\Models\PaymentMethod;
use Payavel\Checkout\Models\PaymentTransaction;
use Payavel\Checkout\Models\Wallet;
use Payavel\Checkout\PaymentRequest;
use Payavel\Checkout\PaymentResponse;
use Payavel\Checkout\PaymentStatus;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Models\Service;

abstract class GatewayTestCase extends TestCase
{
    protected $driver;
    protected $provider = 'test';
    protected $account = 'tester';

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->{"set{$this->driver}Driver"}();
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        config([
            'orchestration.defaults.driver' => $this->driver,
            'orchestration.services.checkout' => [
                'name' => 'Checkout',
                'config' => 'payment',
            ],
            'payment.defaults' => [
                'driver' => $this->driver,
                'provider' => $this->provider,
                'account' => $this->account,
            ],
        ]);
    }

    protected function setConfigDriver()
    {
        config([
            'payment.providers' => [
                $this->provider => [
                    'name' => Str::headline($this->provider),
                    'request_class' => TestPaymentRequest::class,
                    'response_class' => TestPaymentResponse::class,
                ],
                'alternative' => [
                    'name' => 'Alternative',
                    'request_class' => AlternativePaymentRequest::class,
                    'response_class' => AlternativePaymentResponse::class,
                ]
            ],
            'payment.accounts' => [
                $this->account => [
                    'name' => Str::headline($this->account),
                    'providers' => [
                        $this->provider,
                    ],
                ],
                'alternate' => [
                    'name' => 'Alternate',
                    'providers' => [
                        'alternative',
                        $this->provider,
                    ],
                ],
            ],
        ]);
    }

    protected function setDatabaseDriver()
    {
        $service = Service::create([
            'id' => 'checkout',
            'name' => 'Checkout',
        ]);

        $provider = Provider::create([
            'id' => $this->provider,
            'service_id' => $service->id,
            'name' => Str::headline($this->provider),
            'request_class' => TestPaymentRequest::class,
            'response_class' => TestPaymentResponse::class,
        ]);

        $account = Account::create([
            'id' => 'tester',
            'service_id' => $service->id,
            'name' => 'Tester',
        ]);

        $account->providers()->attach($provider->id, ['default' => true]);

        $alternativeProvider = Provider::create([
            'id' => 'alternative',
            'service_id' => $service->id,
            'name' => 'Alternative',
            'request_class' => AlternativePaymentRequest::class,
            'response_class' => AlternativePaymentResponse::class,
        ]);

        $alternateAccount = Account::create([
            'id' => 'alternate',
            'service_id' => $service->id,
            'name' => 'Alternate',
        ]);

        $alternateAccount->providers()->attach($alternativeProvider->id, ['default' => true]);
        $alternateAccount->providers()->attach($provider->id);

    }
}

class TestPaymentRequest extends PaymentRequest
{
    public function getWallet(Wallet $wallet)
    {
        return new TestPaymentResponse([]);
    }

    public function getPaymentMethod(PaymentMethod $paymentMethod)
    {
        return new TestPaymentResponse([]);
    }

    public function tokenizePaymentMethod(Billable $billable, $data)
    {
        return new TestPaymentResponse([]);
    }

    public function updatePaymentMethod(PaymentMethod $paymentMethod, $data)
    {
        return new TestPaymentResponse([]);
    }

    public function deletePaymentMethod(PaymentMethod $paymentMethod)
    {
        return new TestPaymentResponse([]);
    }

    public function authorize($data, Billable $billable = null)
    {
        return new TestPaymentResponse([]);
    }

    public function capture(PaymentTransaction $transaction, $data = [])
    {
        return new TestPaymentResponse([]);
    }

    public function getTransaction(PaymentTransaction $transaction)
    {
        return new TestPaymentResponse([]);
    }

    public function void(PaymentTransaction $paymentTransaction, $data = [])
    {
        return new TestPaymentResponse([]);
    }

    public function refund(PaymentTransaction $paymentTransaction, $data = [])
    {
        return new TestPaymentResponse([]);
    }
}

class TestPaymentResponse extends PaymentResponse
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
        return PaymentStatus::AUTHORIZED;
    }
}

class AlternativePaymentRequest extends PaymentRequest
{
    public function authorize($data, Billable $billable = null)
    {
        return new AlternativePaymentResponse([]);
    }
}

class AlternativePaymentResponse extends PaymentResponse
{
    public function authorizeResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function getStatusCode()
    {
        return PaymentStatus::DECLINED;
    }
}
