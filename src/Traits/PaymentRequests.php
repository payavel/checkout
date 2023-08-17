<?php

namespace Payavel\Checkout\Traits;

use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\Models\PaymentMethod;
use Payavel\Checkout\Models\PaymentTransaction;
use Payavel\Checkout\Models\Wallet;
use Payavel\Serviceable\Traits\ThrowsRuntimeException;

trait PaymentRequests
{
    use ThrowsRuntimeException;

    /**
     * Retrieve the wallet's details from the provider.
     *
     * @param \Payavel\Checkout\Models\Wallet $wallet
     * @return \Payavel\Checkout\PaymentResponse
     */
    public function getWallet(Wallet $wallet)
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Retrieve the payment method's details from the provider.
     * 
     * @param \Payavel\Checkout\Models\PaymentMethod $paymentMethod
     * @return \Payavel\Checkout\PaymentResponse
     */
    public function getPaymentMethod(PaymentMethod $paymentMethod)
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Store the payment method details at the provider.
     * 
     * @param \Payavel\Checkout\Contracts\Billable $billable
     * @param array|mixed $data
     * @return \Payavel\Checkout\PaymentResponse
     */
    public function tokenizePaymentMethod(Billable $billable, $data)
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Update the payment method's details at the provider.
     * 
     * @param \Payavel\Checkout\Models\PaymentMethod $paymentMethod
     * @param array|mixed $data
     * @return \Payavel\Checkout\PaymentResponse
     */
    public function updatePaymentMethod(PaymentMethod $paymentMethod, $data)
    {
        $this->throwRuntimeException(__FUNCTION__);
    }
    
    /**
     * Delete the payment method at the provider.
     * 
     * @param \Payavel\Checkout\Models\PaymentMethod $paymentMethod
     * @return \Payavel\Checkout\PaymentResponse
     */
    public function deletePaymentMethod(PaymentMethod $paymentMethod)
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Authorize a transaction.
     * 
     * @param array|mixed $data
     * @param \Payavel\Checkout\Contracts\Billable|null $billable
     * @return \Payavel\Checkout\PaymentResponse
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
     * @return \Payavel\Checkout\PaymentResponse
     */
    public function capture(PaymentTransaction $transaction, $data = [])
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Retrieve the transaction details from the provider.
     *
     * @param \Payavel\Checkout\Models\PaymentTransaction $transaction
     * @return \Payavel\Checkout\PaymentResponse
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
     * @return \Payavel\Checkout\PaymentResponse
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
     * @return \Payavel\Checkout\PaymentResponse
     */
    public function refund(PaymentTransaction $paymentTransaction, $data = [])
    {
        $this->throwRuntimeException(__FUNCTION__);
    }
}
