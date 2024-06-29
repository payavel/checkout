<?php

namespace Payavel\Checkout;

use Payavel\Orchestration\Service;

class CheckoutGateway extends Service
{
    public function __construct()
    {
        parent::__construct('checkout');
    }

    /**
     * Get or set the service's config.
     *
     * @param string|array $key
     * @param mixed $default
     * @return mixed
     */
    public function config($key, $default = null)
    {
        if (is_array($key)) {
            foreach ($key as $key => $value) {
                $this->config->set($key, $value);
            }

            return;
        }

        return $this->config->get($key, $default);
    }
}
