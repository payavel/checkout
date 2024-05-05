<?php

namespace Payavel\Checkout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\Dispute;

class DisputeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dispute::class;

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
        return $this->afterMaking(function (Dispute $dispute) {
            if (is_null($dispute->payment_id)) {
                $dispute->payment_id = Payment::inRandomOrder()->firstOr(
                    fn () => Payment::factory()->create()
                )->id;
            }

            if (is_null($dispute->amount)) {
                $dispute->amount = $dispute->payment->amount;
            }
        });
    }
}
