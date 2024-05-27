<?php

namespace Payavel\Checkout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Payavel\Checkout\Models\Wallet;
use Payavel\Orchestration\DataTransferObjects\Provider as ProviderDTO;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;
use Payavel\Orchestration\Service;
use Payavel\Orchestration\Support\ServiceConfig;
use Payavel\Orchestration\Tests\Traits\CreatesConfigServiceables;

class WalletFactory extends Factory
{
    use CreatesConfigServiceables;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Wallet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reference' => $this->faker->uuid(),
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
            ServiceConfig::get('checkout', 'defaults.driver') === 'database'
                ? $this->makeSureServiceablesExistInDatabase($wallet)
                : $this->makeSureServiceablesExistInConfig($wallet);
        });
    }

    protected function makeSureServiceablesExistInDatabase(Wallet $wallet)
    {
        if (is_null($wallet->provider_id)) {
            Provider::whereHas(
                'accounts',
                fn ($query) => $query->where('accounts.id', $wallet->account_id)
            )->inRandomOrder()
            ->firstOr(
                fn () => Provider::factory()->create()
            );

            $wallet->provider_id = $provider->id;
        }

        if (is_null($wallet->account_id)) {
            $account = Account::whereHas(
                'providers',
                fn ($query) => $query->where('providers.id', $wallet->provider_id)
            )->inRandomOrder()
            ->firstOr(function () use ($wallet) {
                $account = Account::factory()->create(['default_provider_id' => $wallet->provider_id]);

                $account->providers()->attach($wallet->provider_id);

                return $account;
            });

            $wallet->account_id = $account->id;
        }
    }

    protected function makeSureServiceablesExistInConfig(Wallet $wallet)
    {
        $checkoutService = Service::find('checkout');

        if (is_null($wallet->provider_id)) {
            $provider = $this->createProvider($checkoutService);

            $wallet->provider_id = $provider->getId();
        }

        if (is_null($wallet->account_id)) {
            $account = $this->createAccount($checkoutService);

            $this->linkAccountToProvider($account, $provider ?? new ProviderDTO($checkoutService, ['id' => $wallet->provider_id]));

            $wallet->account_id = $account->id;
        }
    }
}
