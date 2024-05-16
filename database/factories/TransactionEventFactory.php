<?php

namespace Payavel\Checkout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\TransactionEvent;
use Payavel\Checkout\CheckoutStatus;
use Payavel\Checkout\Models\Dispute;
use Payavel\Checkout\Models\Refund;
use Payavel\Orchestration\Support\ServiceConfig;

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
        $this->model = ServiceConfig::get('checkout', 'models.' . $this->model, $this->model);

        return $this->afterMaking(function (TransactionEvent $transactionEvent) {
            if (is_null($transactionEvent->payment_id)) {
                $transactionEvent->payment_id = Payment::factory()->create()->id;
            }

            if (is_null($transactionEvent->amount)) {
                $transactionEvent->amount = $transactionEvent->transactionable->amount ?? $transactionEvent->payment->amount;
            }

            if (is_null($transactionEvent->status_code)) {
                $transactionEvent->status_code = [
                    ServiceConfig::get('checkout', 'models.' . Payment::class, Payment::class) => CheckoutStatus::AUTHORIZED,
                    ServiceConfig::get('checkout', 'models.' . Refund::class, Refund::class) => CheckoutStatus::REFUNDED,
                    ServiceConfig::get('checkout', 'models.' . Dispute::class, Dispute::class) => CheckoutStatus::CHARGEBACK,
                ][
                    ServiceConfig::get('checkout', 'models.' . $transactionEvent->transactionable_type, $transactionEvent->transactionable_type) ??
                    ServiceConfig::get('checkout', 'models.' . Payment::class, Payment::class)
                ];
            }
        });
    }
}
