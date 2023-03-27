<?php

namespace Payavel\Checkout\Contracts;

interface Billable
{
    /**
     * Get the billable's wallets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function wallets();
}
