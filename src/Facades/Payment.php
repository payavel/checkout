<?php

namespace Payavel\Checkout\Facades;

use Illuminate\Support\Facades\Facade;
use Payavel\Checkout\PaymentGateway;

/**
 * @method static \Payavel\Checkout\PaymentGateway provider($provider)
 * @method static \Payavel\Orchestration\Contracts\Providable getProvider()
 * @method static void setProvider($provider)
 * @method static string|int|\Payavel\Orchestration\Contracts\Providable getDefaultProvider()
 * @method static \Payavel\Checkout\PaymentGateway account($account)
 * @method static \Payavel\Orchestration\Contracts\Accountable getAccount()
 * @method static void setAccount($account, $strict = true)
 * @method static void reset()
 * @method static string|int|\Payavel\Orchestration\Contracts\Accountable getDefaultAccount()
 * @method static \Payavel\Checkout\PaymentResponse getWallet(\Payavel\Checkout\Models\Wallet $wallet)
 * @method static \Payavel\Checkout\PaymentResponse getPaymentMethod(\Payavel\Checkout\Models\PaymentMethod $paymentMethod)
 * @method static \Payavel\Checkout\PaymentResponse tokenizePaymentMethod(\Payavel\Checkout\Contracts\Billable $billable, $data)
 * @method static \Payavel\Checkout\PaymentResponse updatePaymentMethod(\Payavel\Checkout\Models\PaymentMethod $paymentMethod, $data)
 * @method static \Payavel\Checkout\PaymentResponse deletePaymentMethod(\Payavel\Checkout\Models\PaymentMethod $paymentMethod)
 * @method static \Payavel\Checkout\PaymentResponse authorize($data, \Payavel\Checkout\Contracts\Billable $billable = null)
 * @method static \Payavel\Checkout\PaymentResponse capture(\Payavel\Checkout\Models\PaymentTransaction $transaction, $data = [])
 * @method static \Payavel\Checkout\PaymentResponse getTransaction(\Payavel\Checkout\Models\PaymentTransaction $transaction)
 * @method static \Payavel\Checkout\PaymentResponse void(\Payavel\Checkout\Models\PaymentTransaction $transaction, $data = [])
 * @method static \Payavel\Checkout\PaymentResponse refund(\Payavel\Checkout\Models\PaymentTransaction $transaction, $data = [])
 *
 * @see \Payavel\Checkout\PaymentGateway
 */
class Payment extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return PaymentGateway::class;
    }
}
