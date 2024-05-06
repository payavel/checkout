<?php

namespace Payavel\Checkout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\TransactionEvent;
use Payavel\Checkout\CheckoutStatus;
use Payavel\Checkout\Models\Dispute;
use Payavel\Checkout\Models\Refund;

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
                $transactionEvent->payment_id = Payment::factory()->create()->id;
            }

            if (is_null($transactionEvent->transactionable_id)) {
                $transactionEvent->transactionable_id = $transactionEvent->payment_id;
                $transactionEvent->transactionable_type = Payment::class;
            }

            if (is_null($transactionEvent->amount)) {
                $transactionEvent->amount = $transactionEvent->transactionable->amount;
            }

            if (is_null($transactionEvent->status_code)) {
                $transactionEvent->status_code = [
                    Payment::class => CheckoutStatus::AUTHORIZED,
                    Refund::class => CheckoutStatus::REFUNDED,
                    Dispute::class => CheckoutStatus::CHARGEBACK,
                ][$transactionEvent->transactionable_type];
            }
        });
    }
}
