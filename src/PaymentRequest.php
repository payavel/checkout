<?php

namespace Payavel\Checkout;

use Payavel\Checkout\Contracts\PaymentRequestor;
use Payavel\Checkout\Traits\PaymentRequests;
use Payavel\Orchestration\Contracts\Merchantable;
use Payavel\Orchestration\Contracts\Providable;

abstract class PaymentRequest implements PaymentRequestor
{
    use PaymentRequests;

    /**
     * The payment provider.
     *
     * @var \Payavel\Orchestration\Contracts\Providable
     */
    protected $provider;

    /**
     * The payment merchant.
     *
     * @var \Payavel\Orchestration\Contracts\Merchantable
     */
    protected $merchant;

    /**
     * @param  \Payavel\Orchestration\Contracts\Providable $provider
     * @param  \Payavel\Orchestration\Contracts\Merchantable $merchant
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
