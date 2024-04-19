<?php

namespace Payavel\Checkout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Payavel\Checkout\Models\PaymentTransaction;
use Payavel\Checkout\CheckoutStatus;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;

class PaymentTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reference' => $this->faker->uuid(),
            'amount' => $this->faker->numberBetween(1, 999) * 100,
            'currency' => $this->faker->currencyCode(),
            'status_code' => CheckoutStatus::AUTHORIZED,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (PaymentTransaction $transaction) {
            if (is_null($transaction->provider_id)) {
                $provider = ! is_null($transaction->payment_method_id)
                    ? $transaction->paymentMethod->provider
                    : Provider::whereHas('accounts', function ($query) use ($transaction) {
                        $query->where('payment_accounts.id', $transaction->account_id);
                    })->inRandomOrder()->firstOr(function () {
                        return Provider::factory()->create();
                    });

                $transaction->provider_id = $provider->id;
            }

            if (is_null($transaction->account_id)) {
                $account = ! is_null($transaction->payment_method_id)
                    ? $transaction->paymentMethod->account
                    : Account::whereHas('providers', function ($query) use ($transaction) {
                        $query->where('payment_providers.id', $transaction->provider_id);
                    })->inRandomOrder()->firstOr(function () use ($transaction) {
                        $account = Account::factory()->create();

                        $account->providers()->attach($transaction->provider_id, ['is_default' => true]);

                        return $account;
                    });

                $transaction->account_id = $account->id;
            }
        });
    }
}
