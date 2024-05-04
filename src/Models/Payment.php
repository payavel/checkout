<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Payavel\Checkout\Traits\ConfiguresCheckoutGateway;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Support\ServiceConfig;
use Payavel\Orchestration\Traits\HasFactory;

class Payment extends Model
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
     * Get the instrument used to process this payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instrument()
    {
        return $this->belongsTo(ServiceConfig::get('checkout', 'models.' . PaymentInstrument::class, PaymentInstrument::class));
    }

    /**
     * Get the provider that processed the payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo(ServiceConfig::get('checkout', 'models.' . Provider::class, Provider::class));
    }

    /**
     * Get the account the payment belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(ServiceConfig::get('checkout', 'models.' . Account::class, Account::class));
    }

    /**
     * Get the payment transaction's event history.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(ServiceConfig::get('checkout', 'models.' . TransactionEvent::class, TransactionEvent::class), 'transaction_id');
    }

    // ToDo: Figure out the new TransactionEvent idea.

    /**
     * Fetch the payment details from the provider.
     *
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function fetch()
    {
        return $this->gateway->getTransaction($this);
    }

    /**
     * Request the provider to void the payment.
     *
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function void($data = [])
    {
        return $this->gateway->void($this, $data);
    }

    /**
     * Request the provider to refund the payment.
     *
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function refund($data = [])
    {
        return $this->gateway->refund($this, $data);
    }
}
