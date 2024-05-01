<?php

namespace Payavel\Checkout\Traits;

use Exception;
use Payavel\Orchestration\Traits\ThrowsRuntimeException;
use RuntimeException;

trait CheckoutResponses
{
    use ThrowsRuntimeException;

    /**
     * Maps details from the getWallet() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function getWalletResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the getPaymentInstrument() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function getPaymentInstrumentResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the tokenizePaymentInstrument() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function tokenizePaymentInstrumentResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the updatePaymentInstrument() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function updatePaymentInstrumentResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the deletePaymentInstrument() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function deletePaymentInstrumentResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the authorize() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function authorizeResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the capture() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function captureResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the getTransaction() response to the expected format.
     *
     * @return array|mixed
     */
    public function getTransactionResponse()
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Maps details from the void() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function voidResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the refund() response to the expected format.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    public function refundResponse()
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Attempts to call the generic response Instrument, else throws RuntimeException.
     *
     * @param string $function
     * @return array|mixed
     *
     * @throws \RuntimeException|Exception
     */
    private function genericResponse($function)
    {
        try {
            return $this->response();
        } catch (Exception $e) {
            if ($e instanceof RuntimeException) {
                $this->throwRuntimeException($function);
            }

            throw($e);
        }
    }

    /**
     * The generic payment request response.
     *
     * @throws \RuntimeException
     */
    public function response()
    {
        return $this->throwRuntimeException(__FUNCTION__);
    }
}
