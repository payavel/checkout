<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Payavel\Checkout\Models\Traits\PaymentMethodRequests;
use Payavel\Orchestration\Support\ServiceConfig;
use Payavel\Orchestration\Traits\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory;
    use PaymentMethodRequests;

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
     * Custom factory namespace fallback.
     *
     * @return string
     */
    protected static function getFactoryNamespace()
    {
        return 'Payavel\\Checkout\\Database\\Factories';
    }

    /**
     * Get the payment method's provider.
     *
     * @return \Payavel\Orchestration\Models\Provider
     */
    public function getProviderAttribute()
    {
        return $this->wallet->provider;
    }

    /**
     * Get the payment method's account.
     *
     * @return \Payavel\Orchestration\Models\Account
     */
    public function getAccountAttribute()
    {
        return $this->wallet->account;
    }

    /**
     * Get the wallet the payment method belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(ServiceConfig::get('checkout', 'models.' . Wallet::class, Wallet::class));
    }

    /**
     * Get the payment method's type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ServiceConfig::get('checkout', 'models.' . PaymentType::class, PaymentType::class));
    }

    /**
     * Get the transactions that this payment method has triggered.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(ServiceConfig::get('checkout', 'models.' . PaymentTransaction::class, PaymentTransaction::class));
    }
}
