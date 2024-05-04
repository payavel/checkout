<?php

namespace Payavel\Checkout\Contracts;

use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\Models\PaymentInstrument;
use Payavel\Checkout\Models\Payment;
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
     * Authorize a payment.
     *
     * @param array|mixed $data
     * @param \Payavel\Checkout\Contracts\Billable|null $billable
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function authorize($data, Billable $billable = null);

    /**
     * Capture an authorized payment.
     *
     * @param \Payavel\Checkout\Models\Payment $payment
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function capture(Payment $payment, $data = []);

    // ToDo: The param should be an instance of Transactionable (Payment, Refund or Dispute)
    /**
     * Retrieve the transaction details from the provider.
     *
     * @param \Payavel\Checkout\Models\Payment $transaction
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function getTransaction(Payment $transaction);

    /**
     * Void an authorized payment.
     *
     * @param \Payavel\Checkout\Models\Payment $payment
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function void(Payment $payment, $data = []);

    /**
     * Refund a payment.
     *
     * @param \Payavel\Checkout\Models\Payment $payment
     * @param array|mixed
     * @return \Payavel\Checkout\CheckoutResponse|mixed
     */
    public function refund(Payment $payment, $data = []);
}
