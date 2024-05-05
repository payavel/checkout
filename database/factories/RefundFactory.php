<?php

namespace Payavel\Checkout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\Refund;

class RefundFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Refund::class;

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
        return $this->afterMaking(function (Refund $refund) {
            if (is_null($refund->payment_id)) {
                $refund->payment_id = Payment::inRandomOrder()->firstOr(
                    fn () => Payment::factory()->create()
                )->id;
            }

            if (is_null($refund->amount)) {
                $refund->amount = $refund->payment->amount;
            }
        });
    }
}
