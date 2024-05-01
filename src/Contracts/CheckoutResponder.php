<?php

namespace Payavel\Checkout\Contracts;

interface CheckoutResponder
{
    /**
     * Maps details from the getWallet() response to the expected format.
     *
     * @return array|mixed
     */
    public function getWalletResponse();

    /**
     * Maps details from the getPaymentInstrument() response to the expected format.
     *
     * @return array|mixed
     */
    public function getPaymentInstrumentResponse();

    /**
     * Maps details from the tokenizePaymentInstrument() response to the expected format.
     *
     * @return array|mixed
     */
    public function tokenizePaymentInstrumentResponse();

    /**
     * Maps details from the updatePaymentInstrument() response to the expected format.
     *
     * @return array|mixed
     */
    public function updatePaymentInstrumentResponse();

    /**
     * Maps details from the deletePaymentInstrument() response to the expected format.
     *
     * @return array|mixed
     */
    public function deletePaymentInstrumentResponse();

    /**
     * Maps details from the authorize() response to the expected format.
     *
     * @return array|mixed
     */
    public function authorizeResponse();

    /**
     * Maps details from the capture() response to the expected format.
     *
     * @return array|mixed
     */
    public function captureResponse();

    /**
     * Maps details from the getTransaction() response to the expected format.
     *
     * @return array|mixed
     */
    public function getTransactionResponse();

    /**
     * Maps details from the void() response to the expected format.
     *
     * @return array|mixed
     */
    public function voidResponse();

    /**
     * Maps details from the refund() response to the expected format.
     *
     * @return array|mixed
     */
    public function refundResponse();
}
