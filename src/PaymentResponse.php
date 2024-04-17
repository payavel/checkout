<?php

namespace Payavel\Checkout;

use Payavel\Checkout\Contracts\PaymentResponder;
use Payavel\Checkout\Traits\PaymentResponses;
use Payavel\Orchestration\ServiceResponse;

abstract class PaymentResponse extends ServiceResponse implements PaymentResponder
{
    use PaymentResponses;

    /**
     * Statuses in this array are considered successful.
     *
     * @var array
     */
    protected $successStatuses = [
        PaymentStatus::AUTHORIZED,
        PaymentStatus::APPROVED,
        PaymentStatus::CAPTURED,
        PaymentStatus::PARTIALLY_CAPTURED,
        PaymentStatus::SETTLED,
        PaymentStatus::CANCELED,
        PaymentStatus::VOIDED,
        PaymentStatus::REFUNDED,
        PaymentStatus::PARTIALLY_REFUNDED,
        PaymentStatus::REFUND_SETTLED,
        PaymentStatus::REFUND_FAILED,
        PaymentStatus::REFUND_REVERSED,
        PaymentStatus::PENDING,
        PaymentStatus::PROCESSING_ASYNC,
    ];

    /**
     * Get a string representation of the response's status.
     *
     * @return string|null
     */
    public function getStatusMessage()
    {
        return PaymentStatus::get($this->getStatusCode());
    }

    /**
     * Get a description of the response's status.
     *
     * @return string|null
     */
    public function getStatusDescription()
    {
        return PaymentStatus::getMessage($this->getStatusCode());
    }
}
