<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Payavel\Checkout\CheckoutResponse;
use Payavel\Checkout\Facades\Checkout;
use Payavel\Orchestration\Traits\HasFactory;

class PaymentInstrument extends Model
{
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
     */
    protected static function getFactoryNamespace(): string
    {
        return 'Payavel\\Checkout\\Database\\Factories';
    }

    /**
     * Get the wallet the payment instrument belongs to.
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Checkout::config('models.' . Wallet::class, Wallet::class));
    }

    /**
     * Get the payment instrument's type
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Checkout::config('models.' . PaymentType::class, PaymentType::class));
    }

    /**
     * Get the payments that this instrument has been used for.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Checkout::config('models.' . Payment::class, Payment::class), 'instrument_id');
    }

    /**
     * Fetch the payment instrument details from the provider.
     */
    public function fetch(): CheckoutResponse
    {
        return $this->wallet->service->getPaymentInstrument($this);
    }

    /**
     * Request the provider to update the payment instrument's details.
     */
    public function patch($data): CheckoutResponse
    {
        return $this->wallet->service->updatePaymentInstrument($this, $data);
    }

    /**
     * Request the provider to remove the payment instrument from their system.
     */
    public function disable(): CheckoutResponse
    {
        return $this->wallet->service->deletePaymentInstrument($this);
    }
}
