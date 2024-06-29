<?php

namespace Payavel\Checkout\Facades;

use Illuminate\Support\Facades\Facade;
use Payavel\Checkout\CheckoutGateway;

/**
 * @method static mixed config($key, $default)
 * @method static \Payavel\Checkout\CheckoutGateway provider($provider)
 * @method static \Payavel\Orchestration\Contracts\Providable getProvider()
 * @method static void setProvider($provider)
 * @method static string|int|\Payavel\Orchestration\Contracts\Providable getDefaultProvider()
 * @method static \Payavel\Checkout\CheckoutGateway account($account)
 * @method static \Payavel\Orchestration\Contracts\Accountable getAccount()
 * @method static void setAccount($account, $strict = true)
 * @method static string|int|\Payavel\Orchestration\Contracts\Accountable getDefaultAccount()
 * @method static void reset()
 * @method static \Payavel\Checkout\CheckoutResponse getWallet(\Payavel\Checkout\Models\Wallet $wallet)
 * @method static \Payavel\Checkout\CheckoutResponse getPaymentInstrument(\Payavel\Checkout\Models\PaymentInstrument $paymentInstrument)
 * @method static \Payavel\Checkout\CheckoutResponse tokenizePaymentInstrument(\Payavel\Checkout\Contracts\Billable $billable, $data)
 * @method static \Payavel\Checkout\CheckoutResponse updatePaymentInstrument(\Payavel\Checkout\Models\PaymentInstrument $paymentInstrument, $data)
 * @method static \Payavel\Checkout\CheckoutResponse deletePaymentInstrument(\Payavel\Checkout\Models\PaymentInstrument $paymentInstrument)
 * @method static \Payavel\Checkout\CheckoutResponse authorize($data, \Payavel\Checkout\Contracts\Billable $billable = null)
 * @method static \Payavel\Checkout\CheckoutResponse capture(\Payavel\Checkout\Models\Payment $payment, $data = [])
 * @method static \Payavel\Checkout\CheckoutResponse getTransaction(\Payavel\Checkout\Models\Payment $transaction)
 * @method static \Payavel\Checkout\CheckoutResponse void(\Payavel\Checkout\Models\Payment $payment, $data = [])
 * @method static \Payavel\Checkout\CheckoutResponse refund(\Payavel\Checkout\Models\Payment $payment, $data = [])
 *
 * @see \Payavel\Checkout\CheckoutGateway
 */
class Checkout extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return CheckoutGateway::class;
    }
}
