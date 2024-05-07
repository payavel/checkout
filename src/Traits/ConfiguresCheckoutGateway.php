<?php

namespace Payavel\Checkout\Traits;

use Payavel\Checkout\CheckoutGateway;

trait ConfiguresCheckoutGateway
{
    /**
     * The checkout model's pre-configured gateway.
     *
     * @var \Payavel\Checkout\CheckoutGateway
     */
    private $checkoutGateway;

    /**
     * Retrieve the checkout model's pre-configured gateway.
     *
     * @return \Payavel\Checkout\CheckoutGateway
     */
    public function getGatewayAttribute()
    {
        if (! isset($this->checkoutGateway)) {
            $this->checkoutGateway = (new CheckoutGateway())
                ->provider($this->provider)
                ->account($this->account);
        }

        return $this->checkoutGateway;
    }
}
