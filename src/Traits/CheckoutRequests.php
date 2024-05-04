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
     *
     * @param \Payavel\Checkout\Models\Wallet $wallet
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function getWallet(Wallet $wallet)
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Retrieve the payment instrument's details from the provider.
     *
     * @param \Payavel\Checkout\Models\PaymentInstrument $paymentInstrument
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function getPaymentInstrument(PaymentInstrument $paymentInstrument)
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Store the payment instrument details at the provider.
     *
     * @param \Payavel\Checkout\Contracts\Billable $billable
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function tokenizePaymentInstrument(Billable $billable, $data)
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Update the payment instrument's details at the provider.
     *
     * @param \Payavel\Checkout\Models\PaymentInstrument $paymentInstrument
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function updatePaymentInstrument(PaymentInstrument $paymentInstrument, $data)
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Delete the payment instrument at the provider.
     *
     * @param \Payavel\Checkout\Models\PaymentInstrument $paymentInstrument
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function deletePaymentInstrument(PaymentInstrument $paymentInstrument)
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Authorize a payment.
     *
     * @param array|mixed $data
     * @param \Payavel\Checkout\Contracts\Billable|null $billable
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function authorize($data, Billable $billable = null)
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Capture an authorized payment.
     *
     * @param \Payavel\Checkout\Models\Payment $payment
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function capture(Payment $payment, $data = [])
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    // ToDo: The param should be an instance of Transactionable (Payment, Refund or Dispute)
    /**
     * Retrieve the transaction details from the provider.
     *
     * @param \Payavel\Checkout\Models\Payment $transaction
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function getTransaction(Payment $transaction)
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Void an authorized payment.
     *
     * @param \Payavel\Checkout\Models\Payment $payment
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function void(Payment $payment, $data = [])
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Refund a payment.
     *
     * @param \Payavel\Checkout\Models\Payment $payment
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function refund(Payment $payment, $data = [])
    {
        $this->throwRuntimeException(__FUNCTION__);
    }
}
