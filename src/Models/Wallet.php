<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Payavel\Checkout\CheckoutResponse;
use Payavel\Checkout\Facades\Checkout;
use Payavel\Orchestration\Contracts\Orchestrable;
use Payavel\Orchestration\Traits\OrchestratesService;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
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
     */
    protected static function getFactoryNamespace(): string
    {
        return 'Payavel\\Checkout\\Database\\Factories';
    }

    /**
     * Get the entity model that this wallet belongs to.
     */
    public function billable(): BelongsTo
    {
        return $this->morphTo();
    }

    /**
     * Get the provider the wallet belongs to.
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Checkout::config('models.' . Provider::class, Provider::class));
    }

    /**
     * Get the account the wallet belongs to.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Checkout::config('models.' . Account::class, Account::class));
    }

    /**
     * Get the wallet's payment instruments.
     */
    public function paymentInstruments(): HasMany
    {
        return $this->hasMany(Checkout::config('models.' . PaymentInstrument::class, PaymentInstrument::class));
    }

    /**
     * Fetch the wallet details from the provider.
     */
    public function fetch(): CheckoutResponse
    {
        return $this->service->getWallet($this);
    }
}
