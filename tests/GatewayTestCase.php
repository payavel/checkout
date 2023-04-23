<?php

namespace Payavel\Checkout\Tests;

use Illuminate\Support\Str;
use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\Models\PaymentMerchant;
use Payavel\Checkout\Models\PaymentMethod;
use Payavel\Checkout\Models\PaymentProvider;
use Payavel\Checkout\Models\PaymentTransaction;
use Payavel\Checkout\Models\Wallet;
use Payavel\Checkout\PaymentRequest;
use Payavel\Checkout\PaymentResponse;
use Payavel\Checkout\PaymentStatus;

abstract class GatewayTestCase extends TestCase
{
    protected $driver;
    protected $provider = 'test';
    protected $merchant = 'tester';

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->{"{$this->driver}DriverSetUp"}();
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('payment.defaults', [
            'driver' => $this->driver,
            'provider' => $this->provider,
            'merchant' => $this->merchant,
        ]);
    }

    protected function configDriverSetUp()
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
            'payment.merchants' => [
                $this->merchant => [
                    'name' => Str::headline($this->merchant),
                    'providers' => [
                        $this->provider => [
                            'is_default' => true,
                        ],
                    ],
                ],
                'alternate' => [
                    'name' => 'Alternate',
                    'providers' => [
                        'alternative' => [
                            'is_default' => true,
                        ],
                        $this->provider => [],
                    ],
                ],
            ],
        ]);
    }

    protected function databaseDriverSetUp()
    {
        $provider = PaymentProvider::create([
            'id' => $this->provider,
            'name' => Str::headline($this->provider),
            'request_class' => TestPaymentRequest::class,
            'response_class' => TestPaymentResponse::class,
        ]);

        $merchant = PaymentMerchant::create([
            'id' => 'tester',
            'name' => 'Tester',
        ]);

        $merchant->providers()->attach($provider->id, ['is_default' => true]);

        $alternativeProvider = PaymentProvider::create([
            'id' => 'alternative',
            'name' => 'Alternative',
            'request_class' => AlternativePaymentRequest::class,
            'response_class' => AlternativePaymentResponse::class,
        ]);

        $alternateMerchant = PaymentMerchant::create([
            'id' => 'alternate',
            'name' => 'Alternate',
        ]);

        $alternateMerchant->providers()->attach($alternativeProvider->id, ['is_default' => true]);
        $alternateMerchant->providers()->attach($provider->id);

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

    public function void(PaymentTransaction $paymentTransaction, $data =[])
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
        return new TestPaymentResponse([]);
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
