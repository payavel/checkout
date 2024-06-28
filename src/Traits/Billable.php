<?php

namespace Payavel\Checkout\Traits;

use Payavel\Checkout\Models\Wallet;
use Payavel\Orchestration\ServiceConfig;

trait Billable
{
    /**
     * Get the billable's wallets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function wallets()
    {
        return $this->morphMany(ServiceConfig::find('checkout')->get('models.' . Wallet::class, Wallet::class), 'billable');
    }
}
