<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Payavel\Orchestration\Fluent\ServiceConfig;
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
        return $this->belongsTo(ServiceConfig::find('checkout')->get('models.' . Payment::class, Payment::class));
    }

    /**
     * Get the transaction specific events.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function transactionEvents()
    {
        return $this->morphMany(ServiceConfig::find('checkout')->get('models.' . TransactionEvent::class, TransactionEvent::class), 'transactionable');
    }
}
