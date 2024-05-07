<?php

namespace Payavel\Checkout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\PaymentRail;
use Payavel\Orchestration\Models\Account;
use Payavel\Orchestration\Models\Provider;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

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
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Payment $payment) {
            if (is_null($payment->provider_id)) {
                $provider = ! is_null($payment->instrument_id)
                    ? $payment->instrument->provider
                    : Provider::whereHas(
                        'accounts',
                        fn ($query) => $query->where('accounts.id', $payment->account_id)
                    )->inRandomOrder()->firstOr(
                        fn () => Provider::factory()->create()
                    );

                $payment->provider_id = $provider->id;
            }

            if (is_null($payment->account_id)) {
                $account = ! is_null($payment->instrument_id)
                    ? $payment->instrument->account
                    : Account::whereHas(
                        'providers',
                        fn ($query) => $query->where('providers.id', $payment->provider_id)
                    )->inRandomOrder()
                    ->firstOr(function () use ($payment) {
                        $account = Account::factory()->create();

                        $account->providers()->attach($payment->provider_id, ['is_default' => true]);

                        return $account;
                    });

                $payment->account_id = $account->id;
            }

            if (is_null($payment->rail_id)) {
                $rail = ! is_null($payment->instrument_id)
                    ? $payment->instrument->type->rails()->inRandomOrder()->firstOrCreate(
                        ['parent_type_id' => $payment->instrument->type_id],
                        ['type_id' => $payment->instrument->type_id]
                    ) : PaymentRail::inRandomOrder()
                        ->firstOr(
                            fn () => PaymentRail::factory()->create()
                        );

                $payment->rail_id = $rail->id;
            }
        });
    }
}
