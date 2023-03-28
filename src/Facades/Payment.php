<?php

namespace Payavel\Checkout\Facades;

use Illuminate\Support\Facades\Facade;
use Payavel\Checkout\PaymentGateway;

/**
 * @method static \Payavel\Checkout\PaymentGateway provider($provider)
 * @method static \Payavel\Checkout\Models\PaymentProvider getProvider()
 * @method static void setProvider($provider)
 * @method static string|int|\Payavel\Checkout\Models\PaymentProvider getDefaultProvider()
 * @method static \Payavel\Checkout\PaymentGateway merchant($merchant)
 * @method static \Payavel\Checkout\Models\PaymentMerchant getMerchant()
 * @method static void setMerchant($merchant, $strict = true)
 * @method static string|int getDefaultMerchant()
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
    protected static function getFacadeAccessor()
    {
        return PaymentGateway::class;
    }
}
