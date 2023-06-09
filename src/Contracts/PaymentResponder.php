<?php

namespace Payavel\Checkout\Contracts;

interface PaymentResponder
{
    /**
     * Maps details from the getWallet() response to the expected format.
     *
     * @return array|mixed
     */
    public function getWalletResponse();

    /**
     * Maps details from the getPaymentMethod() response to the expected format.
     *
     * @return array|mixed
     */
    public function getPaymentMethodResponse();

    /**
     * Maps details from the tokenizePaymentMethod() response to the expected format.
     *
     * @return array|mixed
     */
    public function tokenizePaymentMethodResponse();

    /**
     * Maps details from the updatePaymentMethod() response to the expected format.
     *
     * @return array|mixed
     */
    public function updatePaymentMethodResponse();
    
    /**
     * Maps details from the deletePaymentMethod() response to the expected format.
     *
     * @return array|mixed
     */
    public function deletePaymentMethodResponse();

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
