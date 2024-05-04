<?php

namespace Payavel\Checkout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\TransactionEvent;
use Payavel\Checkout\CheckoutStatus;

class TransactionEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TransactionEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reference' => $this->faker->uuid(),
            'status_code' => $this->faker->randomElement([
                CheckoutStatus::CAPTURED,
                CheckoutStatus::SETTLED,
                CheckoutStatus::VOIDED,
                CheckoutStatus::REFUNDED,
                CheckoutStatus::REFUND_SETTLED,
            ]),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (TransactionEvent $transactionEvent) {
            if (is_null($transactionEvent->payment_id)) {
                $payment = Payment::factory()->create();

                $transactionEvent->payment_id = $payment->id;
            }

            if (is_null($transactionEvent->amount)) {
                $transactionEvent->amount = $transactionEvent->transaction->amount;
            }
        });
    }
}
