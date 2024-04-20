<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Payavel\Checkout\Traits\ConfiguresCheckoutGateway;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Support\ServiceConfig;
use Payavel\Orchestration\Traits\HasFactory;

class PaymentTransaction extends Model
{
    use ConfiguresCheckoutGateway;
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'reference',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'details' => 'array',
    ];

    /**
     * Custom factory namespace fallback.
     *
     * @return string
     */
    protected static function getFactoryNamespace()
    {
        return 'Payavel\\Checkout\\Database\\Factories';
    }

    /**
     * Get the payment method used for this transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentMethod()
    {
        return $this->belongsTo(ServiceConfig::get('checkout', 'models.' . PaymentMethod::class, PaymentMethod::class));
    }

    /**
     * Get the provider the transaction belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo(ServiceConfig::get('checkout', 'models.' . Provider::class, Provider::class));
    }

    /**
     * Get the account the transaction belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(ServiceConfig::get('checkout', 'models.' . Account::class, Account::class));
    }

    /**
     * Get the transaction's event history.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(ServiceConfig::get('checkout', 'models.' . PaymentTransactionEvent::class, PaymentTransactionEvent::class), 'transaction_id');
    }

    /**
     * Fetch the transaction details from the provider.
     *
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function fetch()
    {
        return $this->gateway->getTransaction($this);
    }

    /**
     * Request the provider to void the transaction.
     *
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function void($data = [])
    {
        return $this->gateway->void($this, $data);
    }

    /**
     * Request the provider to refund the transaction.
     *
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function refund($data = [])
    {
        return $this->gateway->refund($this, $data);
    }
}
