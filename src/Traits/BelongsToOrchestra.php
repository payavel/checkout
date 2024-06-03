<?php

namespace Payavel\Checkout\Traits;

use Payavel\Orchestration\Service;

// ToDo: Move to Orchestration.
trait BelongsToOrchestra
{
    /**
     * The orchestra's attributes.
     *
     * @var array
     */
    protected $orchestra = [];

    public function getProvider()
    {
        if (!isset($this->orchestra['provider'])) {
            $this->orchestra['provider'] = $this->getServiceDriver()->resolveProvider($this->provider_id);
        }

        return $this->orchestra['provider'];
    }

    public function getAccount()
    {
        if (!isset($this->orchestra['account'])) {
            $this->orchestra['account'] = $this->getServiceDriver()->resolveAccount($this->account_id);
        }

        return $this->orchestra['account'];
    }

    public function getServiceDriver()
    {
        if (!isset($this->orchestra['driver'])) {
            $this->orchestra['driver'] = $this->getService()->getDriver();
        }

        return $this->orchestra['driver'];
    }

    public function getService()
    {
        if (!isset($this->orchestra['service'])) {
            $this->orchestra['service'] = Service::find($this->serviceId);
        }

        return $this->orchestra['service'];
    }
}
