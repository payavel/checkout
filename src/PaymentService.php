<?php

namespace Payavel\Checkout;

use Exception;
use Payavel\Checkout\Traits\SimulateAttributes;

class PaymentService
{
    use SimulateAttributes;

    /**
     * The payment service driver that will handle provider & merchant configurations.
     *
     * @var \Payavel\Checkout\PaymentServiceDriver
     */
    private $driver;

    /**
     * The payment provider requests will be forwarded to.
     *
     * @var \Payavel\Checkout\Contracts\Providable
     */
    private $provider;

    /**
     * The merchant that will be passed to the provider's gateway.
     *
     * @var \Payavel\Checkout\Contracts\Merchantable
     */
    private $merchant;

    /**
     * The gateway class where requests will be executed.
     *
     * @var \Payavel\Checkout\PaymentRequest
     */
    private $gateway;

    /**
     * Prepares the driver based on preference determined in config file.
     *
     * @return void
     *
     * @throws Exception
     */
    public function __construct()
    {
        if (! class_exists($driver = config('payment.drivers.' . config('payment.defaults.driver', 'config')))) {
            throw new Exception('Invalid checkout driver provided.');
        }

        $this->driver = new $driver;
    }

    /**
     * Fluent provider setter.
     *
     * @param \Payavel\Checkout\Contracts\Providable|string|int $provider
     * @return \Payavel\Checkout\PaymentService
     */
    public function provider($provider)
    {
        $this->setProvider($provider);

        return $this;
    }

    /**
     * Get the current payment provider.
     *
     * @return \Payavel\Checkout\Contracts\Providable
     */
    public function getProvider()
    {
        if (! isset($this->provider)) {
            $this->setProvider($this->getDefaultProvider());
        }

        return $this->provider;
    }

    /**
     * Set the payment provider.
     *
     * @param \Payavel\Checkout\Contracts\Providable|string|int $provider
     * @return void
     *
     * @throws Exception
     */
    public function setProvider($provider)
    {
        if (is_null($provider = $this->driver->resolveProvider($provider))) {
            throw new Exception('Invalid checkout provider.');
        }

        $this->provider = $provider;

        $this->gateway = null;
    }

    /**
     * Get the default payment provider.
     *
     * @return string|int|\Payavel\Checkout\Contracts\Providable
     */
    public function getDefaultProvider()
    {
        return $this->driver->getDefaultProvider($this->merchant);
    }

    /**
     * Fluent merchant setter.
     *
     * @param \Payavel\Checkout\Contracts\Merchantable|string|int $merchant
     * @return \Payavel\Checkout\PaymentService
     */
    public function merchant($merchant)
    {
        $this->setMerchant($merchant);

        return $this;
    }

    /**
     * Get the current merchant.
     *
     * @return \Payavel\Checkout\Contracts\Merchantable
     */
    public function getMerchant()
    {
        if (! isset($this->merchant)) {
            $this->setMerchant($this->getDefaultMerchant());
        }

        return $this->merchant;
    }

    /**
     * Set the specified merchant.
     *
     * @param \Payavel\Checkout\Contracts\Merchantable|string|int $merchant
     * @return void
     *
     * @throws Exception
     */
    public function setMerchant($merchant)
    {
        if (is_null($merchant = $this->driver->resolveMerchant($merchant))) {
            throw new Exception('Invalid checkout merchant.');
        }

        $this->merchant = $merchant;

        $this->gateway = null;
    }

    /**
     * Get the default merchant.
     *
     * @return string|int|\Payavel\Checkout\Contracts\Merchantable
     */
    public function getDefaultMerchant()
    {
        return $this->driver->getDefaultMerchant($this->provider);
    }

    /**
     * Get the payment gateway service.
     *
     * @return \Payavel\Checkout\PaymentRequest
     */
    protected function getGateway()
    {
        if (! isset($this->gateway)) {
            $this->setGateway();
        }

        return $this->gateway;
    }

    /**
     * Instantiate a new instance of the payment gateway.
     *
     * @return void
     *
     * @throws Exception
     */
    protected function setGateway()
    {
        $provider = $this->getProvider();
        $merchant = $this->getMerchant();

        if (! $this->driver->check($provider, $merchant)) {
            throw new Exception("The {$merchant->getName()} merchant is not supported by the {$provider->getName()} provider.");
        }

        $gateway = config('payment.test_mode')
            ? config('payment.mocking.request_class')
            : $this->driver->resolveGatewayClass($provider);

        if (! class_exists($gateway)) {
            throw new Exception('The ' . $gateway . '::class does not exist.');
        }

        $this->gateway = new $gateway($provider, $merchant);
    }
}
