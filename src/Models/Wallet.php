<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Payavel\Checkout\Database\Factories\WalletFactory;
use Payavel\Checkout\Models\Traits\WalletRequests;
use Payavel\Serviceable\Models\Merchant;
use Payavel\Serviceable\Models\Provider;

class Wallet extends Model
{
    use HasFactory,
        WalletRequests;

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
    protected $hidden = ['token'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return WalletFactory::new();
    }

    /**
     * Get the entity model that this wallet belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function billable()
    {
        return $this->morphTo();
    }

    /**
     * Get the provider the wallet belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo(config('payment.models.' . Provider::class, Provider::class));
    }

    /**
     * Get the merchant the wallet belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function merchant()
    {
        return $this->belongsTo(config('payment.models.' . Merchant::class, Merchant::class));
    }

    /**
     * Get the wallet's payment methods.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentMethods()
    {
        return $this->hasMany(config('payment.models.' . PaymentMethod::class, PaymentMethod::class));
    }
}
