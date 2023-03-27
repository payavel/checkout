<?php

namespace Payavel\Checkout;

use Payavel\Checkout\Contracts\Merchantable;
use Payavel\Checkout\Contracts\Providable;

abstract class PaymentServiceDriver
{
    /**
     * Resolve the providable instance.
     *
     * @param \Payavel\Checkout\Contracts\Providable|string|int $provider
     * @return \Payavel\Checkout\Contracts\Providable|null
     */
    abstract public function resolveProvider($provider);

    /**
     * Get the default providable identifier.
     *
     * @param \Payavel\Checkout\Contracts\Merchantable|null $merchant
     * @return string|int
     */
    public function getDefaultProvider(Merchantable $merchant = null)
    {
        return config('payment.defaults.provider');
    }

    /**
     * Resolve the merchantable intance.
     *
     * @param \Payavel\Checkout\Contracts\Merchantable|string|int $merchant
     * @return \Payavel\Checkout\Contracts\Merchantable|null
     */
    abstract public function resolveMerchant($merchant);

    /**
     * Get the default merchantable identifier.
     *
     * @param \Payavel\Checkout\Contracts\Providable|null $provider
     * @return string|int
     */
    public function getDefaultMerchant(Providable $provider = null)
    {
        return config('payment.defaults.merchant');
    }

    /**
     * Verify that the merchant is compatible with the provider.
     *
     * @param \Payavel\Checkout\Contracts\Providable
     * @param \Payavel\Checkout\Contracts\Merchantable
     * @return bool
     */
    abstract public function check($provider, $merchant);

    /**
     * Resolve the gateway class.
     *
     * @param \Payavel\Checkout\Contracts\Providable $provider
     * @return string
     */
    abstract public function resolveGatewayClass($provider);
}
