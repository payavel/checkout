<?php

namespace Payavel\Checkout\Contracts;

use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\Models\PaymentInstrument;
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
     * Retrieve the payment instrument's details from the provider.
     *
     * @param \Payavel\Checkout\Models\PaymentInstrument $paymentInstrument
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function getPaymentInstrument(PaymentInstrument $paymentInstrument);

    /**
     * Store the payment instrument details at the provider.
     *
     * @param \Payavel\Checkout\Contracts\Billable $billable
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function tokenizePaymentInstrument(Billable $billable, $data);

    /**
     * Update the payment instrument's details at the provider.
     *
     * @param \Payavel\Checkout\Models\PaymentInstrument $paymentInstrument
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function updatePaymentInstrument(PaymentInstrument $paymentInstrument, $data);

    /**
     * Delete the payment instrument at the provider.
     *
     * @param \Payavel\Checkout\Models\PaymentInstrument $paymentInstrument
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function deletePaymentInstrument(PaymentInstrument $paymentInstrument);

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
