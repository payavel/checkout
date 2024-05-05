<?php

namespace Payavel\Checkout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Payavel\Checkout\Models\PaymentRail;
use Payavel\Checkout\Models\PaymentType;

class PaymentRailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentRail::class;

    public const REAL = [
        [
            'parent_type_id' => 'visa',
            'type_id' => 'visa',
        ],
        [
            'parent_type_id' => 'mastercard',
            'type_id' => 'mastercard',
        ],
        [
            'parent_type_id' => 'amex',
            'type_id' => 'amex',
        ],
        [
            'parent_type_id' => 'discover',
            'type_id' => 'discover',
        ],
        [
            'parent_type_id' => 'diners_club',
            'type_id' => 'diners_club',
        ],
        [
            'parent_type_id' => 'jcb',
            'type_id' => 'jcb',
        ],
        [
            'parent_type_id' => 'apple_pay',
            'type_id' => 'visa',
        ],
        [
            'parent_type_id' => 'apple_pay',
            'type_id' => 'mastercard',
        ],
        [
            'parent_type_id' => 'apple_pay',
            'type_id' => 'amex',
        ],
        [
            'parent_type_id' => 'apple_pay',
            'type_id' => 'discover',
        ],
        [
            'parent_type_id' => 'google_pay',
            'type_id' => 'visa',
        ],
        [
            'parent_type_id' => 'google_pay',
            'type_id' => 'mastercard',
        ],
        [
            'parent_type_id' => 'google_pay',
            'type_id' => 'amex',
        ],
        [
            'parent_type_id' => 'google_pay',
            'type_id' => 'discover',
        ],
        [
            'parent_type_id' => 'paypal',
            'type_id' => 'paypal',
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [];
    }

    public function real()
    {
        return $this->state(function () {
            $existingPaymentRails = PaymentRail::all()->pluck('id');

            $rail = collect(static::REAL)
                ->filter(function ($realPaymentRail) use ($existingPaymentRails) {
                    $realPaymentRailId = $realPaymentRail['parent_type_id'] === $realPaymentRail['type_id']
                    ? $realPaymentRail['type_id']
                    : "{$realPaymentRail['parent_type_id']}:{$realPaymentRail['type_id']}";

                    return $existingPaymentRails->doesntContain($realPaymentRailId);
                })
                ->first();

            if (is_null($rail)) {
                return [];
            }

            return $rail;
        });
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (PaymentRail $paymentRail) {
            if (is_null($paymentRail->parent_type_id)) {
                $paymentRail->parent_type_id = PaymentType::inRandomOrder()->firstOr(
                    fn () => PaymentType::factory()->create()
                )->id;
            }

            if (is_null($paymentRail->type_id)) {
                $paymentRail->type_id = PaymentType::factory()->create()->id;
            }
        });
    }
}
