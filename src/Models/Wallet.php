<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Payavel\Checkout\Models\Traits\WalletRequests;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Support\ServiceConfig;
use Payavel\Orchestration\Traits\HasFactory;

class Wallet extends Model
{
    use HasFactory;
    use WalletRequests;

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
     * Custom factory namespace fallback.
     *
     * @return string
     */
    protected static function getFactoryNamespace()
    {
        return 'Payavel\\Checkout\\Database\\Factories';
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
        return $this->belongsTo(ServiceConfig::get('checkout', 'models.' . Provider::class, Provider::class));
    }

    /**
     * Get the account the wallet belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(ServiceConfig::get('checkout', 'models.' . Account::class, Account::class));
    }

    /**
     * Get the wallet's payment methods.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentMethods()
    {
        return $this->hasMany(ServiceConfig::get('checkout', 'models.' . PaymentMethod::class, PaymentMethod::class));
    }
}
