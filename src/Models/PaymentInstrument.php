<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
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
     *
     * @return string
     */
    protected static function getFactoryNamespace()
    {
        return 'Payavel\\Checkout\\Database\\Factories';
    }

    /**
     * Get the wallet the payment instrument belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Checkout::config('models.' . Wallet::class, Wallet::class));
    }

    /**
     * Get the payment instrument's type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Checkout::config('models.' . PaymentType::class, PaymentType::class));
    }

    /**
     * Get the payments that this instrument has been used for.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Checkout::config('models.' . Payment::class, Payment::class), 'instrument_id');
    }

    /**
     * Fetch the payment instrument details from the provider.
     *
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function fetch()
    {
        return $this->wallet->service->getPaymentInstrument($this);
    }

    /**
     * Request the provider to update the payment instrument's details.
     *
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function patch($data)
    {
        return $this->wallet->service->updatePaymentInstrument($this, $data);
    }

    /**
     * Request the provider to remove the payment instrument from their system.
     *
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function disable()
    {
        return $this->wallet->service->deletePaymentInstrument($this);
    }
}
