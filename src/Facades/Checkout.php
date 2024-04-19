<?php

namespace Payavel\Checkout\Facades;

use Illuminate\Support\Facades\Facade;
use Payavel\Checkout\CheckoutGateway;

/**
 * @method static \Payavel\Checkout\CheckoutGateway provider($provider)
 * @method static \Payavel\Orchestration\Contracts\Providable getProvider()
 * @method static void setProvider($provider)
 * @method static string|int|\Payavel\Orchestration\Contracts\Providable getDefaultProvider()
 * @method static \Payavel\Checkout\CheckoutGateway account($account)
 * @method static \Payavel\Orchestration\Contracts\Accountable getAccount()
 * @method static void setAccount($account, $strict = true)
 * @method static void reset()
 * @method static string|int|\Payavel\Orchestration\Contracts\Accountable getDefaultAccount()
 * @method static \Payavel\Checkout\CheckoutResponse getWallet(\Payavel\Checkout\Models\Wallet $wallet)
 * @method static \Payavel\Checkout\CheckoutResponse getPaymentMethod(\Payavel\Checkout\Models\PaymentMethod $paymentMethod)
 * @method static \Payavel\Checkout\CheckoutResponse tokenizePaymentMethod(\Payavel\Checkout\Contracts\Billable $billable, $data)
 * @method static \Payavel\Checkout\CheckoutResponse updatePaymentMethod(\Payavel\Checkout\Models\PaymentMethod $paymentMethod, $data)
 * @method static \Payavel\Checkout\CheckoutResponse deletePaymentMethod(\Payavel\Checkout\Models\PaymentMethod $paymentMethod)
 * @method static \Payavel\Checkout\CheckoutResponse authorize($data, \Payavel\Checkout\Contracts\Billable $billable = null)
 * @method static \Payavel\Checkout\CheckoutResponse capture(\Payavel\Checkout\Models\PaymentTransaction $transaction, $data = [])
 * @method static \Payavel\Checkout\CheckoutResponse getTransaction(\Payavel\Checkout\Models\PaymentTransaction $transaction)
 * @method static \Payavel\Checkout\CheckoutResponse void(\Payavel\Checkout\Models\PaymentTransaction $transaction, $data = [])
 * @method static \Payavel\Checkout\CheckoutResponse refund(\Payavel\Checkout\Models\PaymentTransaction $transaction, $data = [])
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
