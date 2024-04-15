<?php

namespace Payavel\Checkout\Models\Traits;

use Payavel\Checkout\PaymentGateway;

trait ConfiguresPaymentGateway
{
    /**
     * The payment method's pre-configured gateway.
     *
     * @var \Payavel\Checkout\PaymentGateway
     */
    private $paymentGateway;

    /**
     * Retrieve the payment method's configured gateway.
     *
     * @return \Payavel\Checkout\PaymentGateway
     */
    public function getGatewayAttribute()
    {
        if (! isset($this->paymentGateway)) {
            $this->paymentGateway = (new PaymentGateway())
                ->provider($this->provider)
                ->account($this->account);
        }

        return $this->paymentGateway;
    }
}
