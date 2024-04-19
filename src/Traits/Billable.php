<?php

namespace Payavel\Checkout\Traits;

use Payavel\Checkout\Models\Wallet;
use Payavel\Orchestration\Support\ServiceConfig;

trait Billable
{
    /**
     * Get the billable's wallets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function wallets()
    {
        return $this->morphMany(ServiceConfig::get('checkout', 'models.' . Wallet::class, Wallet::class), 'billable');
    }
}
