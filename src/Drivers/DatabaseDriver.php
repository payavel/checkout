<?php

namespace Payavel\Checkout\Drivers;

use Payavel\Checkout\Contracts\Merchantable;
use Payavel\Checkout\Models\PaymentMerchant;
use Payavel\Checkout\Models\PaymentProvider;
use Payavel\Checkout\PaymentServiceDriver;

class DatabaseDriver extends PaymentServiceDriver
{
    /**
     * Resolve the providable instance.
     *
     * @param \Payavel\Checkout\Contracts\Providable|string $provider
     * @return \Payavel\Checkout\Contracts\Providable|null
     */
    public function resolveProvider($provider)
    {
        if (! $provider instanceof PaymentProvider) {
            $provider = PaymentProvider::find($provider);
        }

        if (is_null($provider) || (! $provider->exists)) {
            return null;
        }

        return $provider;
    }

    /**
     * Get the default providable identifier.
     *
     * @param \Payavel\Checkout\Contracts\Merchantable|null $merchant
     * @return string|int
     */
    public function getDefaultProvider(Merchantable $merchant = null)
    {
        if (! $merchant instanceof PaymentMerchant || is_null($provider = $merchant->providers()->wherePivot('is_default', true)->first())) {
            return parent::getDefaultProvider();
        }

        return $provider;
    }

    /**
     * Resolve the merchantable intance.
     *
     * @param \Payavel\Checkout\Contracts\Merchantable|string $merchant
     * @return \Payavel\Checkout\Contracts\Merchantable|null
     */
    public function resolveMerchant($merchant)
    {
        if (! $merchant instanceof PaymentMerchant) {
            $merchant = PaymentMerchant::find($merchant);
        }

        if (is_null($merchant) || (! $merchant->exists)) {
            return null;
        }

        return $merchant;
    }

    /**
     * Verify that the merchant is compatible with the provider.
     *
     * @param \Payavel\Checkout\Contracts\Providable
     * @param \Payavel\Checkout\Contracts\Merchantable
     * @return bool
     */
    public function check($provider, $merchant)
    {
        if (! $merchant->providers->contains($provider)) {
            return false;
        }

        return true;
    }

    /**
     * Resolve the gateway class.
     *
     * @param \Payavel\Checkout\Contracts\Providable $provider
     * @return string
     */
    public function resolveGatewayClass($provider)
    {
        return $provider->request_class;
    }
}
