<?php

namespace Payavel\Checkout\Traits;

use Payavel\Checkout\Models\Wallet;

trait Billable
{
    /**
     * Get the billable's wallets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function wallets()
    {
        return $this->morphMany(config('payment.models.' . Wallet::class, Wallet::class), 'billable');
    }
}
