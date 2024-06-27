<?php

namespace Payavel\Checkout\Tests\Unit\Database;

use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Tests\Models\TestAccount;
use Payavel\Checkout\Tests\Models\TestProvider;
use Payavel\Checkout\Tests\Unit\TestPaymentModel;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Fluent\ServiceConfig;
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
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ];

        $paymentWithProvider = Payment::factory()->create($usingServiceables);
        $this->assertInstanceOf(Provider::class, $paymentWithProvider->provider);

        ServiceConfig::find('checkout')->set('models.' . Provider::class, TestProvider::class);
        $paymentWithOverriddenProvider = Payment::factory()->create($usingServiceables);
        $this->assertInstanceOf(TestProvider::class, $paymentWithOverriddenProvider->provider);
    }

    #[Test]
    public function retrieve_payment_account()
    {
        $usingServiceables = [
            'provider_id' => $this->createProvider($this->checkoutService)->getId(),
            'account_id' => $this->createAccount($this->checkoutService)->getId(),
        ];

        $paymentWithAccount = Payment::factory()->create($usingServiceables);
        $this->assertInstanceOf(Account::class, $paymentWithAccount->account);

        ServiceConfig::find('checkout')->set('models.' . Account::class, TestAccount::class);
        $paymentWithOverriddenAccount = Payment::factory()->create($usingServiceables);
        $this->assertInstanceOf(TestAccount::class, $paymentWithOverriddenAccount->account);
    }
}
