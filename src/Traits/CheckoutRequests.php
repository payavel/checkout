<?php

namespace Payavel\Checkout\Traits;

use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\Models\PaymentInstrument;
use Payavel\Checkout\Models\PaymentTransaction;
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
     * Authorize a transaction.
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
     * Capture a previously authorized transaction.
     *
     * @param \Payavel\Checkout\Models\PaymentTransaction $transaction
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function capture(PaymentTransaction $transaction, $data = [])
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Retrieve the transaction details from the provider.
     *
     * @param \Payavel\Checkout\Models\PaymentTransaction $transaction
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function getTransaction(PaymentTransaction $transaction)
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Void a previously authorized transaction.
     *
     * @param \Payavel\Checkout\Models\PaymentTransaction $paymentTransaction
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function void(PaymentTransaction $paymentTransaction, $data = [])
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Refund a previously captured transaction.
     *
     * @param \Payavel\Checkout\Models\PaymentTransaction $paymentTransaction
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function refund(PaymentTransaction $paymentTransaction, $data = [])
    {
        $this->throwRuntimeException(__FUNCTION__);
    }
}
