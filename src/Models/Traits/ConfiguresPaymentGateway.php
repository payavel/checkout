<?php

namespace Payavel\Checkout\Models\Traits;

use Payavel\Checkout\CheckoutGateway;

trait ConfiguresPaymentGateway
{
    /**
     * The payment method's pre-configured gateway.
     *
     * @var \Payavel\Checkout\CheckoutGateway
     */
    private $paymentGateway;

    /**
     * Retrieve the payment method's configured gateway.
     *
     * @return \Payavel\Checkout\CheckoutGateway
     */
    public function getGatewayAttribute()
    {
        if (! isset($this->paymentGateway)) {
            $this->paymentGateway = (new CheckoutGateway())
                ->provider($this->provider)
                ->account($this->account);
        }

        return $this->paymentGateway;
    }
}
