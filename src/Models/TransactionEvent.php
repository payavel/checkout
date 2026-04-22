<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Payavel\Checkout\Facades\Checkout;
use Payavel\Orchestration\Traits\HasFactory;

class TransactionEvent extends Model
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
     */
    protected static function getFactoryNamespace(): string
    {
        return 'Payavel\\Checkout\\Database\\Factories';
    }

    /**
     * Get the event's originating payment.
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Checkout::config('models.' . Payment::class, Payment::class));
    }

    /**
     * Get the event's originating transaction.
     */
    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }
}
