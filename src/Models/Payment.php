<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Payavel\Orchestration\Contracts\Orchestrable;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\ServiceConfig;
use Payavel\Orchestration\Traits\OrchestratesService;
use Payavel\Orchestration\Traits\HasFactory;

class Payment extends Model implements Orchestrable
{
    use HasFactory;
    use OrchestratesService;

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
     * The orchestra's service id.
     *
     * @var string
     */
    protected $serviceId = 'checkout';

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
     * Get the provider that processed the payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo(ServiceConfig::find('checkout')->get('models.' . Provider::class, Provider::class));
    }

    /**
     * Get the account the payment belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(ServiceConfig::find('checkout')->get('models.' . Account::class, Account::class));
    }

    /**
     * Get the rail the payment was processed on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rail()
    {
        return $this->belongsTo(ServiceConfig::find('checkout')->get('models.' . PaymentRail::class, PaymentRail::class));
    }

    /**
     * Get the instrument used to process this payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instrument()
    {
        return $this->belongsTo(ServiceConfig::find('checkout')->get('models.' . PaymentInstrument::class, PaymentInstrument::class));
    }

    /**
     * Get the payment event full history.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(ServiceConfig::find('checkout')->get('models.' . TransactionEvent::class, TransactionEvent::class));
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

    /**
     * Fetch the payment details from the provider.
     *
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function fetch()
    {
        return $this->service->getTransaction($this);
    }

    /**
     * Request the provider to void the payment.
     *
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function void($data = [])
    {
        return $this->service->void($this, $data);
    }

    /**
     * Request the provider to refund the payment.
     *
     * @param array|mixed $data
     * @return \Payavel\Checkout\CheckoutResponse
     */
    public function refund($data = [])
    {
        return $this->service->refund($this, $data);
    }
}
