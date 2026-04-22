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
     */
    public function getWallet(Wallet $wallet): mixed;

    /**
     * Retrieve the payment instrument's details from the provider.
     */
    public function getPaymentInstrument(PaymentInstrument $paymentInstrument): mixed;

    /**
     * Store the payment instrument details at the provider.
     */
    public function tokenizePaymentInstrument(Billable $billable, $data): mixed;

    /**
     * Update the payment instrument's details at the provider.
     */
    public function updatePaymentInstrument(PaymentInstrument $paymentInstrument, $data): mixed;

    /**
     * Delete the payment instrument at the provider.
     */
    public function deletePaymentInstrument(PaymentInstrument $paymentInstrument): mixed;

    /**
     * Authorize a payment.
     */
    public function authorize($data, ?Billable $billable): mixed;

    /**
     * Capture an authorized payment.
     */
    public function capture(Payment $payment, $data = []): mixed;

    // ToDo: The param should be an instance of Transactionable (Payment, Refund or Dispute)
    /**
     * Retrieve the transaction details from the provider.
     */
    public function getTransaction(Payment $transaction): mixed;

    /**
     * Void an authorized payment.
     */
    public function void(Payment $payment, $data = []): mixed;

    /**
     * Refund a payment.
     */
    public function refund(Payment $payment, $data = []): mixed;
}
