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
     * Get the payment that is being refunded.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment()
    {
        return $this->belongsTo(ServiceConfig::get('checkout', 'models.' . Payment::class, Payment::class));
    }

    /**
     * Get the refund's provider.
     *
     * @return \Payavel\Orchestration\Models\Provider
     */
    public function getProviderAttribute()
    {
        return $this->payment->provider;
    }

    /**
     * Get the refund's account.
     *
     * @return \Payavel\Orchestration\Models\Account
     */
    public function getAccountAttribute()
    {
        return $this->payment->account;
    }
}
