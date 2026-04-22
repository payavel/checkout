<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Payavel\Checkout\Facades\Checkout;
use Payavel\Orchestration\Traits\HasFactory;

class PaymentType extends Model
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
    protected $guarded = [];

    /**
     * Custom factory namespace fallback.
     */
    protected static function getFactoryNamespace(): string
    {
        return 'Payavel\\Checkout\\Database\\Factories';
    }

    /**
     * Get the payment rail this type could potentially use.
     */
    public function rails(): HasMany
    {
        return $this->hasMany(Checkout::config('models.' . PaymentRail::class, PaymentRail::class), 'parent_type_id');
    }

    /**
     * Get the payment instruments that inherit this type.
     */
    public function instruments(): HasMany
    {
        return $this->hasMany(Checkout::config('models.' . PaymentInstrument::class, PaymentInstrument::class), 'type_id');
    }
}
