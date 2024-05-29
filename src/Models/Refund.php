<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Payavel\Orchestration\Support\ServiceConfig;
use Payavel\Orchestration\Traits\HasFactory;

class Refund extends Model
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
     * Get the transaction specific events.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function transactionEvents()
    {
        return $this->morphMany(ServiceConfig::get('checkout', 'models.' . TransactionEvent::class, TransactionEvent::class), 'transactionable');
    }
}
