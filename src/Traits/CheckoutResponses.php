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
     * @throws \RuntimeException|Exception
     */
    public function getWalletResponse(): mixed
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the getPaymentInstrument() response to the expected format.
     *
     * @throws \RuntimeException|Exception
     */
    public function getPaymentInstrumentResponse(): mixed
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the tokenizePaymentInstrument() response to the expected format.
     *
     * @throws \RuntimeException|Exception
     */
    public function tokenizePaymentInstrumentResponse(): mixed
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the updatePaymentInstrument() response to the expected format.
     *
     * @throws \RuntimeException|Exception
     */
    public function updatePaymentInstrumentResponse(): mixed
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the deletePaymentInstrument() response to the expected format.
     *
     * @throws \RuntimeException|Exception
     */
    public function deletePaymentInstrumentResponse(): mixed
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the authorize() response to the expected format.
     *
     * @throws \RuntimeException|Exception
     */
    public function authorizeResponse(): mixed
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the capture() response to the expected format.
     *
     * @throws \RuntimeException|Exception
     */
    public function captureResponse(): mixed
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the getTransaction() response to the expected format.
    *
     * @throws \RuntimeException|Exception 
    */
    public function getTransactionResponse(): mixed
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Maps details from the void() response to the expected format.
     *
     * @throws \RuntimeException|Exception
     */
    public function voidResponse(): mixed
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Maps details from the refund() response to the expected format.
     *
     * @throws \RuntimeException|Exception
     */
    public function refundResponse(): mixed
    {
        return $this->genericResponse(__FUNCTION__);
    }

    /**
     * Attempts to call the generic response Instrument, else throws RuntimeException.
     *
     * @throws \RuntimeException|Exception
     */
    private function genericResponse(string $function): mixed
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
    public function response(): mixed
    {
        return $this->throwRuntimeException(__FUNCTION__);
    }
}
