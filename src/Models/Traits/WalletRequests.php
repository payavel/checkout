<?php

namespace Payavel\Checkout\Models\Traits;

trait WalletRequests
{
    use ConfiguresCheckoutGateway;

    /**
     * Fetch the wallet details from the provider.
     *
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function fetch()
    {
        return $this->gateway->getWallet($this);
    }
}
