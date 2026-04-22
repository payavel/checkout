<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Payavel\Checkout\CheckoutResponse;
use Payavel\Checkout\Facades\Checkout;
use Payavel\Orchestration\Contracts\Orchestrable;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Traits\OrchestratesService;
use Payavel\Orchestration\Traits\HasFactory;

class Payment extends Model implements Orchestrable
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
     * The orchestra's service id.
     */
    protected string $serviceId = 'checkout';

    /**
     * Custom factory namespace fallback.
     */
    protected static function getFactoryNamespace(): string
    {
        return 'Payavel\\Checkout\\Database\\Factories';
    }

    /**
     * Get the provider that processed the payment.
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Checkout::config('models.' . Provider::class, Provider::class));
    }

    /**
     * Get the account the payment belongs to.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Checkout::config('models.' . Account::class, Account::class));
    }

    /**
     * Get the rail the payment was processed on.
     */
    public function rail(): BelongsTo
    {
        return $this->belongsTo(Checkout::config('models.' . PaymentRail::class, PaymentRail::class));
    }

    /**
     * Get the instrument used to process this payment.
     */
    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Checkout::config('models.' . PaymentInstrument::class, PaymentInstrument::class));
    }

    /**
     * Get the payment event full history.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Checkout::config('models.' . TransactionEvent::class, TransactionEvent::class));
    }

    /**
     * Get the transaction specific events.
     */
    public function transactionEvents(): MorphMany
    {
        return $this->morphMany(Checkout::config('models.' . TransactionEvent::class, TransactionEvent::class), 'transactionable');
    }

    /**
     * Fetch the payment details from the provider.
     */
    public function fetch(): CheckoutResponse
    {
        return $this->service->getTransaction($this);
    }

    /**
     * Request the provider to void the payment.
     */
    public function void($data = []): CheckoutResponse
    {
        return $this->service->void($this, $data);
    }

    /**
     * Request the provider to refund the payment.
     */
    public function refund($data = []): CheckoutResponse
    {
        return $this->service->refund($this, $data);
    }
}
