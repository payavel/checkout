<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Payavel\Orchestration\Contracts\Orchestrable;
use Payavel\Orchestration\Traits\OrchestratesService;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Support\ServiceConfig;
use Payavel\Orchestration\Traits\HasFactory;

class Wallet extends Model implements Orchestrable
{
    use HasFactory;
    use OrchestratesService;

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
    protected $hidden = ['reference'];

    /**
     * The orchestra's service id.
     *
     * @var string
     */
    protected $serviceId = 'checkout';

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
     * Get the wallet's payment instruments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentInstruments()
    {
        return $this->hasMany(ServiceConfig::get('checkout', 'models.' . PaymentInstrument::class, PaymentInstrument::class));
    }

    /**
     * Fetch the wallet details from the provider.
     *
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function fetch()
    {
        return $this->service->getWallet($this);
    }
}
