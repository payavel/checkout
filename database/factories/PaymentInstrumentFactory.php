<?php

namespace Payavel\Checkout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Payavel\Checkout\Models\Wallet;
use Payavel\Checkout\Models\PaymentInstrument;
use Payavel\Checkout\Models\PaymentType;

class PaymentInstrumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentInstrument::class;

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
        return $this->afterMaking(function (PaymentInstrument $paymentInstrument) {
            if(is_null($paymentInstrument->wallet_id)) {
                $wallet = Wallet::inRandomOrder()->firstOr(
                    fn () => Wallet::factory()->create()
                );

                $paymentInstrument->wallet_id = $wallet->id;
            }

            if (is_null($paymentInstrument->type_id)) {
                $type = PaymentType::inRandomOrder()->firstOr(
                    fn () => PaymentType::factory()->create()
                );

                $paymentInstrument->type_id = $type->id;
            }
        });
    }
}
