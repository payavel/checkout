<?php

namespace Payavel\Checkout\Traits;

use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\Models\PaymentInstrument;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\Wallet;
use Payavel\Orchestration\Traits\ThrowsRuntimeException;

trait CheckoutRequests
{
    use ThrowsRuntimeException;

    /**
     * Retrieve the wallet's details from the provider.
     */
    public function getWallet(Wallet $wallet): mixed
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Retrieve the payment instrument's details from the provider.
     */
    public function getPaymentInstrument(PaymentInstrument $paymentInstrument): mixed
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Store the payment instrument details at the provider.
     */
    public function tokenizePaymentInstrument(Billable $billable, $data): mixed
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Update the payment instrument's details at the provider.
     */
    public function updatePaymentInstrument(PaymentInstrument $paymentInstrument, $data): mixed
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Delete the payment instrument at the provider.
     */
    public function deletePaymentInstrument(PaymentInstrument $paymentInstrument): mixed
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Authorize a payment.
     */
    public function authorize($data, ?Billable $billable): mixed
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Capture an authorized payment.
     */
    public function capture(Payment $payment, $data = []): mixed
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    // ToDo: The param should be an instance of Transactionable (Payment, Refund or Dispute)
    /**
     * Retrieve the transaction details from the provider.
     */
    public function getTransaction(Payment $transaction): mixed
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Void an authorized payment.
     */
    public function void(Payment $payment, $data = []): mixed
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Refund a payment.
     */
    public function refund(Payment $payment, $data = []): mixed
    {
        $this->throwRuntimeException(__FUNCTION__);
    }
}
