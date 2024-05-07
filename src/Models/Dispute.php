<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Payavel\Orchestration\Support\ServiceConfig;
use Payavel\Orchestration\Traits\HasFactory;

class Dispute extends Model
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
     * Get the payment that is being disputed.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment()
    {
        return $this->belongsTo(ServiceConfig::get('checkout', 'models.' . Payment::class, Payment::class));
    }

    /**
     * Get the dispute's provider.
     *
     * @return \Payavel\Orchestration\Models\Provider
     */
    public function getProviderAttribute()
    {
        return $this->payment->provider;
    }

    /**
     * Get the dispute's account.
     *
     * @return \Payavel\Orchestration\Models\Account
     */
    public function getAccountAttribute()
    {
        return $this->payment->account;
    }

    /**
     * Get the transaction specific events.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function transactionEvents()
    {
        return $this->morphMany(ServiceConfig::get('checkout', 'models.' . TransactionEvent::class, TransactionEvent::class), 'transactionable');
    }
}
