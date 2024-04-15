<?php

namespace Payavel\Checkout;

use Payavel\Checkout\Contracts\PaymentRequestor;
use Payavel\Checkout\Traits\PaymentRequests;
use Payavel\Orchestration\Contracts\Accountable;
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
     * The payment account.
     *
     * @var \Payavel\Orchestration\Contracts\Accountable
     */
    protected $account;

    /**
     * @param  \Payavel\Orchestration\Contracts\Providable $provider
     * @param  \Payavel\Orchestration\Contracts\Accountable $account
     */
    public function __construct(Providable $provider, Accountable $account)
    {
        $this->provider = $provider;
        $this->account = $account;

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
