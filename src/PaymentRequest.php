<?php

namespace Payavel\Checkout;

use Payavel\Checkout\Contracts\Merchantable;
use Payavel\Checkout\Contracts\PaymentRequestor;
use Payavel\Checkout\Contracts\Providable;
use Payavel\Checkout\Traits\PaymentRequests;

abstract class PaymentRequest implements PaymentRequestor
{
    use PaymentRequests;

    /**
     * The payment provider.
     *
     * @var \Payavel\Checkout\Contracts\Providable
     */
    protected $provider;

    /**
     * The payment merchant.
     *
     * @var \Payavel\Checkout\Contracts\Merchantable
     */
    protected $merchant;

    /**
     * @param  \Payavel\Checkout\Contracts\Providable $provider
     * @param  \Payavel\Checkout\Contracts\Merchantable $merchant
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
