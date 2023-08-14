<?php

namespace Payavel\Checkout\Drivers;

use Payavel\Checkout\Models\PaymentMerchant;
use Payavel\Checkout\Models\PaymentProvider;
use Payavel\Checkout\PaymentServiceDriver;
use Payavel\Serviceable\Contracts\Merchantable;

class DatabaseDriver extends PaymentServiceDriver
{
    /**
     * Resolve the providable instance.
     *
     * @param \Payavel\Serviceable\Contracts\Providable|string $provider
     * @return \Payavel\Serviceable\Contracts\Providable|null
     */
    public function resolveProvider($provider)
    {
        if (! $provider instanceof PaymentProvider) {
            $paymentProvider = config('payment.models.' . PaymentProvider::class, PaymentProvider::class);

            $provider = $paymentProvider::find($provider);
        }

        if (is_null($provider) || (! $provider->exists)) {
            return null;
        }

        return $provider;
    }

    /**
     * Get the default providable identifier.
     *
     * @param \Payavel\Serviceable\Contracts\Merchantable|null $merchant
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
     * @param \Payavel\Serviceable\Contracts\Merchantable|string $merchant
     * @return \Payavel\Serviceable\Contracts\Merchantable|null
     */
    public function resolveMerchant($merchant)
    {
        if (! $merchant instanceof PaymentMerchant) {
            $paymentMerchant = config('payment.models.' . PaymentMerchant::class, PaymentMerchant::class);

            $merchant = $paymentMerchant::find($merchant);
        }

        if (is_null($merchant) || (! $merchant->exists)) {
            return null;
        }

        return $merchant;
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
        if (! $merchant->providers->contains($provider)) {
            return false;
        }

        return true;
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
