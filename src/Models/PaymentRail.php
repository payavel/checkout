<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Payavel\Orchestration\Fluent\ServiceConfig;
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
     * @return void
     */
    protected static function booted(): void
    {
        static::saving(function (PaymentRail $paymentRail) {
            $paymentRail->id = $paymentRail->parent_type_id === $paymentRail->type_id
                ? $paymentRail->type_id
                : "{$paymentRail->parent_type_id}:{$paymentRail->type_id}";
        });
    }

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
     * Get the parent payment type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentType()
    {
        return $this->belongsTo(ServiceConfig::find('checkout')->get('models.' . PaymentType::class, PaymentType::class));
    }

    /**
     * Get the rail's payment type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ServiceConfig::find('checkout')->get('models.' . PaymentType::class, PaymentType::class));
    }

    /**
     * Get the payments that were processed over this rail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(ServiceConfig::find('checkout')->get('models.' . Payment::class, Payment::class), 'rail_id');
    }
}
