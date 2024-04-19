<?php

namespace Payavel\Checkout\Models\Traits;

trait PaymentTransactionRequests
{
    use ConfiguresPaymentGateway;

    /**
     * Fetch the transaction details from the provider.
     *
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function fetch()
    {
        return $this->gateway->getTransaction($this);
    }

    /**
     * Request the provider to void the transaction.
     *
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function void($data = [])
    {
        return $this->gateway->void($this, $data);
    }

    /**
     * Request the provider to refund the transaction.
     *
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function refund($data = [])
    {
        return $this->gateway->refund($this, $data);
    }
}
