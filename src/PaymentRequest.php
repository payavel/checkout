<?php

namespace Payavel\Checkout;

use Payavel\Checkout\Contracts\PaymentRequestor;
use Payavel\Checkout\Traits\PaymentRequests;
use Payavel\Serviceable\Contracts\Merchantable;
use Payavel\Serviceable\Contracts\Providable;

abstract class PaymentRequest implements PaymentRequestor
{
    use PaymentRequests;

    /**
     * The payment provider.
     *
     * @var \Payavel\Serviceable\Contracts\Providable
     */
    protected $provider;

    /**
     * The payment merchant.
     *
     * @var \Payavel\Serviceable\Contracts\Merchantable
     */
    protected $merchant;

    /**
     * @param  \Payavel\Serviceable\Contracts\Providable $provider
     * @param  \Payavel\Serviceable\Contracts\Merchantable $merchant
     */
    public function __construct(Providable $provider, Merchantable $merchant)
    {
        $this->provider = $provider;
        $this->merchant = $merchant;

        $this->setUp();
    }

    /**
     * Set up the request.
     *
     * @return void
     */
    protected function setUp()
    {
        //
    }
}
