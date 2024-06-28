<?php

namespace Payavel\Checkout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Payavel\Checkout\CheckoutStatus;
use Payavel\Checkout\Models\Dispute;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\Refund;
use Payavel\Checkout\Models\TransactionEvent;
use Payavel\Orchestration\ServiceConfig;

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
        $this->model = ServiceConfig::find('checkout')->get('models.' . $this->model, $this->model);

        return $this->afterMaking(function (TransactionEvent $transactionEvent) {
            if (is_null($transactionEvent->payment_id)) {
                $transactionEvent->payment_id = $transactionEvent->transactionable_type === Payment::class ? $transactionEvent->transactionable_id : Payment::factory()->create()->id;
            }

            if (is_null($transactionEvent->amount)) {
                $transactionEvent->amount = $transactionEvent->transactionable->amount ?? $transactionEvent->payment->amount;
            }

            if (is_null($transactionEvent->status_code) && !is_null($transactionEvent->transactionable_type)) {
                $transactionable = new $transactionEvent->transactionable_type();

                if ($transactionable instanceof Payment) {
                    $transactionEvent->status_code = CheckoutStatus::AUTHORIZED;
                } elseif ($transactionable instanceof Refund) {
                    $transactionEvent->status_code = CheckoutStatus::REFUNDED;
                } elseif ($transactionable instanceof Dispute) {
                    $transactionEvent->status_code = CheckoutStatus::CHARGEBACK;
                }
            }
        });
    }
}
