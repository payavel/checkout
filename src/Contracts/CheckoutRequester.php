<?php

namespace Payavel\Checkout\Contracts;

use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\Models\PaymentMethod;
use Payavel\Checkout\Models\PaymentTransaction;
use Payavel\Checkout\Models\Wallet;

interface CheckoutRequester
{
    /**
     * Retrieve the wallet's details from the provider.
     *
     * @param \Payavel\Checkout\Models\Wallet $wallet
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function getWallet(Wallet $wallet);

    /**
     * Retrieve the payment method's details from the provider.
     *
     * @param \Payavel\Checkout\Models\PaymentMethod $paymentMethod
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function getPaymentMethod(PaymentMethod $paymentMethod);

    /**
     * Store the payment method details at the provider.
     *
     * @param \Payavel\Checkout\Contracts\Billable $billable
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function tokenizePaymentMethod(Billable $billable, $data);

    /**
     * Update the payment method's details at the provider.
     *
     * @param \Payavel\Checkout\Models\PaymentMethod $paymentMethod
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function updatePaymentMethod(PaymentMethod $paymentMethod, $data);

    /**
     * Delete the payment method at the provider.
     *
     * @param \Payavel\Checkout\Models\PaymentMethod $paymentMethod
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function deletePaymentMethod(PaymentMethod $paymentMethod);

    /**
     * Authorize a transaction.
     *
     * @param array|mixed $data
     * @param \Payavel\Checkout\Contracts\Billable|null $billable
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function authorize($data, Billable $billable = null);

    /**
     * Capture a previously authorized transaction.
     *
     * @param \Payavel\Checkout\Models\PaymentTransaction $transaction
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function capture(PaymentTransaction $transaction, $data = []);

    /**
     * Retrieve the transaction details from the provider.
     *
     * @param \Payavel\Checkout\Models\PaymentTransaction $transaction
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function getTransaction(PaymentTransaction $transaction);

    /**
     * Void a previously authorized transaction.
     *
     * @param \Payavel\Checkout\Models\PaymentTransaction $transaction
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function void(PaymentTransaction $transaction, $data = []);

    /**
     * Refund a previously captured transaction.
     *
     * @param \Payavel\Checkout\Models\PaymentTransaction $transaction
     * @param array|mixed
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function refund(PaymentTransaction $transaction, $data = []);
}
