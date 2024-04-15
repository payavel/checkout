<?php

namespace Payavel\Checkout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Payavel\Checkout\Models\Wallet;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;

class WalletFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @return string
     */
    public function modelName()
    {
        return config('payment.models.' . Wallet::class, Wallet::class);
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'token' => $this->faker->uuid(),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Wallet $wallet) {
            if (is_null($wallet->provider_id)) {
                $provider = Provider::whereHas('accounts', function ($query) use ($wallet) {
                    $query->where('payment_accounts.id', $wallet->account_id);
                })->inRandomOrder()->firstOr(function () {
                    return Provider::factory()->create();
                });

                $wallet->provider_id = $provider->id;
            }

            if (is_null($wallet->account_id)) {
                $account = Account::whereHas('providers', function ($query) use ($wallet) {
                    $query->where('payment_providers.id', $wallet->provider_id);
                })->inRandomOrder()->firstOr(function () use ($wallet) {
                    $account = Account::factory()->create();

                    $account->providers()->attach($wallet->provider_id, ['is_default' => true]);

                    return $account;
                });

                $wallet->account_id = $account->id;
            }
        });
    }
}
