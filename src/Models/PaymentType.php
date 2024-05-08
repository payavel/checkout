<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Payavel\Orchestration\Support\ServiceConfig;
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
     *
     * @return string
     */
    protected static function getFactoryNamespace()
    {
        return 'Payavel\\Checkout\\Database\\Factories';
    }

    /**
     * Get the payment rail this type could potentially use.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rails()
    {
        return $this->hasMany(ServiceConfig::get('checkout', 'models.' . PaymentRail::class, PaymentRail::class), 'parent_type_id');
    }

    /**
     * Get the payment instruments that inherit this type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function instruments()
    {
        return $this->hasMany(ServiceConfig::get('checkout', 'models.' . PaymentInstrument::class, PaymentInstrument::class), 'type_id');
    }
}
