<?php

namespace Payavel\Checkout\Tests\Unit;

use Illuminate\Support\Facades\Config;
use Payavel\Checkout\Facades\Checkout;
use Payavel\Checkout\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CheckoutConfigTest extends TestCase
{
    #[Test]
    public function get_checkout_config_via_facade()
    {
        Config::set('checkout.test', true);

        $this->assertTrue(Checkout::config('test', false));
    }

    #[Test]
    public function set_checkout_config_via_facade()
    {
        Checkout::config([
            'test' => [
                'one' => true,
                'two' => true,
            ]
        ]);

        $this->assertIsArray(Config::get('checkout.test'));
        $this->assertCount(2, Config::get('checkout.test'));
        $this->assertTrue(Config::get('checkout.test.one', false));

        Checkout::config([
            'test.one' => false,
            'test.three' => true,
        ]);

        $this->assertCount(3, Config::get('checkout.test'));
        $this->assertFalse(Config::get('checkout.test.one', true));
        $this->assertArrayHasKey('three', Config::get('checkout.test', []));
    }
}
