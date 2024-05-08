<?php

namespace Payavel\Checkout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Payavel\Checkout\Models\PaymentType;

class PaymentTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentType::class;

    public const REAL = [
        [
            'id' => 'visa',
            'name' => 'VISA',
        ],
        [
            'id' => 'mastercard',
            'name' => 'MasterCard',
        ],
        [
            'id' => 'amex',
            'name' => 'AMEX',
        ],
        [
            'id' => 'discover',
            'name' => 'Discover',
        ],
        [
            'id' => 'diners_club',
            'name' => 'Diners Club',
        ],
        [
            'id' => 'jcb',
            'name' => 'JCB',
        ],
        [
            'id' => 'apple_pay',
            'name' => 'Apple Pay',
        ],
        [
            'id' => 'google_pay',
            'name' => 'Google Pay',
        ],
        [
            'id' => 'paypal',
            'name' => 'PayPal',
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = Str::ucfirst($this->faker->unique()->lexify(Str::repeat('?', rand(4, 8))));

        return [
            'id' => preg_replace('/[^a-z]+/i', '_', Str::lower($name)),
            'name' => $name,
        ];
    }

    public function real()
    {
        return $this->state(function () {
            $type = collect(static::REAL)->whereNotIn('id', PaymentType::all()->pluck('id'))->first();

            if (is_null($type)) {
                return [];
            }

            return $type;
        });
    }
}
