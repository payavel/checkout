<?php

namespace Payavel\Checkout\Models\Traits;

trait WalletRequests
{
    use ConfiguresPaymentGateway;

    /**
     * Fetch the wallet details from the provider.
     *
     * @return \Payavel\Checkout\PaymentResponse
     */
    public function fetch()
    {
        return $this->gateway->getWallet($this);
    }
}
