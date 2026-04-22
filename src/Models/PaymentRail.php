<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Payavel\Checkout\Facades\Checkout;
use Payavel\Orchestration\Traits\HasFactory;

class PaymentRail extends Model
{
    use HasFactory;

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

    /**
     * Set the rail's id.
     */
    protected static function booted(): void
    {
        static::saving(function (PaymentRail $paymentRail): void {
            $paymentRail->id = $paymentRail->parent_type_id === $paymentRail->type_id
                ? $paymentRail->type_id
                : "{$paymentRail->parent_type_id}:{$paymentRail->type_id}";
        });
    }

    /**
     * Custom factory namespace fallback.
     */
    protected static function getFactoryNamespace(): string
    {
        return 'Payavel\\Checkout\\Database\\Factories';
    }

    /**
     * Get the parent payment type.
     */
    public function parentType(): BelongsTo
    {
        return $this->belongsTo(Checkout::config('models.' . PaymentType::class, PaymentType::class));
    }

    /**
     * Get the rail's payment type.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Checkout::config('models.' . PaymentType::class, PaymentType::class));
    }

    /**
     * Get the payments that were processed over this rail.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Checkout::config('models.' . Payment::class, Payment::class), 'rail_id');
    }
}
