<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Payavel\Checkout\Database\Factories\PaymentMethodFactory;
use Payavel\Checkout\Models\Traits\PaymentMethodRequests;

class PaymentMethod extends Model
{
    use HasFactory,
        PaymentMethodRequests;

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
        'token',
        'details',
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
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PaymentMethodFactory::new();
    }

    /**
     * Get the payment method's provider.
     *
     * @deprecated 1.1.0 No longer used by internal code.
     * @return \Payavel\Checkout\Models\PaymentProvider
     */
    public function getProviderAttribute()
    {
        return $this->wallet->provider;
    }

    /**
     * Get the payment method's merchant.
     *
     * @deprecated 1.1.0 No longer used by internal code.
     * @return \Payavel\Checkout\Models\PaymentMerchant
     */
    public function getMerchantAttribute()
    {
        return $this->wallet->merchant;
    }

    /**
     * Get the payment method's provider id.
     *
     * @return string|int
     */
    public function getProviderIdAttribute()
    {
        return $this->wallet->provider_id;
    }

    /**
     * Get the payment method's merchant id.
     *
     * @return string|int
     */
    public function getMerchantIdAttribute()
    {
        return $this->wallet->merchant_id;
    }

    /**
     * Get the wallet the payment method belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(config('payment.models.' . Wallet::class, Wallet::class));
    }

    /**
     * Get the payment method's type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(config('payment.models.' . PaymentType::class, PaymentType::class));
    }

    /**
     * Get the transactions that this payment method has triggered.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(config('payment.models.' . PaymentTransaction::class, PaymentTransaction::class));
    }
}
