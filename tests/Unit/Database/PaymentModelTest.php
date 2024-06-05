<?php

namespace Payavel\Checkout\Tests\Unit\Database;

use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Tests\Models\TestAccount;
use Payavel\Checkout\Tests\Models\TestProvider;
use Payavel\Checkout\Tests\Unit\TestPaymentModel;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Support\ServiceConfig;
use Payavel\Orchestration\Tests\Traits\CreatesDatabaseServiceables;
use Payavel\Orchestration\Tests\Traits\SetsDatabaseDriver;
use PHPUnit\Framework\Attributes\Test;

class PaymentModelTest extends TestPaymentModel
{
    use CreatesDatabaseServiceables;
    use SetsDatabaseDriver;

    #[Test]
    public function retrieve_payment_provider()
    {
        $paymentWithProvider = Payment::factory()->create();
        $this->assertInstanceOf(Provider::class, $paymentWithProvider->provider);

        ServiceConfig::set('checkout', 'models.' . Provider::class, TestProvider::class);
        $paymentWithOverriddenProvider = Payment::factory()->create();
        $this->assertInstanceOf(TestProvider::class, $paymentWithOverriddenProvider->provider);
    }

    #[Test]
    public function retrieve_payment_account()
    {
        $paymentWithAccount = Payment::factory()->create();
        $this->assertInstanceOf(Account::class, $paymentWithAccount->account);

        ServiceConfig::set('checkout', 'models.' . Account::class, TestAccount::class);
        $paymentWithOverriddenAccount = Payment::factory()->create();
        $this->assertInstanceOf(TestAccount::class, $paymentWithOverriddenAccount->account);
    }
}
