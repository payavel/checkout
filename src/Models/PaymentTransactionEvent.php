<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Payavel\Orchestration\Support\ServiceConfig;
use Payavel\Orchestration\Traits\HasFactory;

class PaymentTransactionEvent extends Model
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
     * Get the event's original transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(ServiceConfig::get('checkout', 'models.' . PaymentTransaction::class, PaymentTransaction::class));
    }
}
