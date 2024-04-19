<?php

namespace Payavel\Checkout;

use Payavel\Checkout\Contracts\CheckoutResponder;
use Payavel\Checkout\Traits\CheckoutResponses;
use Payavel\Orchestration\ServiceResponse;

abstract class CheckoutResponse extends ServiceResponse implements CheckoutResponder
{
    use CheckoutResponses;

    /**
     * Statuses in this array are considered successful.
     *
     * @var array
     */
    protected $successStatuses = [
        CheckoutStatus::AUTHORIZED,
        CheckoutStatus::APPROVED,
        CheckoutStatus::CAPTURED,
        CheckoutStatus::PARTIALLY_CAPTURED,
        CheckoutStatus::SETTLED,
        CheckoutStatus::CANCELED,
        CheckoutStatus::VOIDED,
        CheckoutStatus::REFUNDED,
        CheckoutStatus::PARTIALLY_REFUNDED,
        CheckoutStatus::REFUND_SETTLED,
        CheckoutStatus::REFUND_FAILED,
        CheckoutStatus::REFUND_REVERSED,
        CheckoutStatus::PENDING,
        CheckoutStatus::PROCESSING_ASYNC,
    ];

    /**
     * Get a string representation of the response's status.
     *
     * @return string|null
     */
    public function getStatusMessage()
    {
        return CheckoutStatus::get($this->getStatusCode());
    }

    /**
     * Get a description of the response's status.
     *
     * @return string|null
     */
    public function getStatusDescription()
    {
        return CheckoutStatus::getMessage($this->getStatusCode());
    }
}
