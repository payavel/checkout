<?php

namespace Payavel\Checkout\Drivers;

use Payavel\Checkout\DataTransferObjects\Merchant;
use Payavel\Checkout\DataTransferObjects\Provider;
use Payavel\Checkout\PaymentServiceDriver;
use Payavel\Serviceable\Contracts\Merchantable;

class ConfigDriver extends PaymentServiceDriver
{
    /**
     * Collection of the application'n payment providers.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $providers;

    /**
     * Collection of the application's merchants.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $merchants;


    /**
     * Collect the application's payment providers & merchants.
     */
    public function __construct()
    {
        $this->providers = collect(config('payment.providers'));
        $this->merchants = collect(config('payment.merchants'));
    }

    /**
     * Resolve the providable instance.
     *
     * @param \Payavel\Serviceable\Contracts\Providable|string $provider
     * @return \Payavel\Serviceable\Contracts\Providable|null
     */
    public function resolveProvider($provider)
    {
        if ($provider instanceof Provider) {
            return $provider;
        }

        if (is_null($attributes = $this->providers->get($provider))) {
            return null;
        }

        return new Provider(array_merge(['id' => $provider], $attributes));
    }

    /**
     * Get the default providable identifier.
     *
     * @param \Payavel\Serviceable\Contracts\Merchantable|null $merchant
     * @return string|int|\Payavel\Serviceable\Contracts\Providable
     */
    public function getDefaultProvider(Merchantable $merchant = null)
    {
        if (
            ! $merchant instanceof Merchant ||
            is_null($provider = $merchant->providers->first())
        ) {
            return parent::getDefaultProvider();
        }

        return $provider['id'];
    }

    /**
     * Resolve the merchantable instance.
     *
     * @param \Payavel\Serviceable\Contracts\Merchantable|string $merchant
     * @return \Payavel\Serviceable\Contracts\Merchantable|null
     */
    public function resolveMerchant($merchant)
    {
        if ($merchant instanceof Merchant) {
            return $merchant;
        }

        if (is_null($attributes = $this->merchants->get($merchant))) {
            return null;
        }

        return new Merchant(array_merge(['id' => $merchant], $attributes));
    }

    /**
     * Verify that the merchant is compatible with the provider.
     *
     * @param \Payavel\Serviceable\Contracts\Providable
     * @param \Payavel\Serviceable\Contracts\Merchantable
     * @return bool
     */
    public function check($provider, $merchant)
    {
        return $merchant->providers->contains('id', $provider->id);
    }

    /**
     * Resolve the gateway class.
     *
     * @param \Payavel\Serviceable\Contracts\Providable $provider
     * @return string
     */
    public function resolveGatewayClass($provider)
    {
        return $provider->request_class;
    }
}
