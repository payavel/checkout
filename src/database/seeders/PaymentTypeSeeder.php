<?php

namespace Payavel\Checkout\Database\Seeders;

use Illuminate\Database\Seeder;
use Payavel\Checkout\Database\Factories\PaymentTypeFactory;
use Payavel\Checkout\Models\PaymentType;

class PaymentTypeSeeder extends Seeder
{
    public function run()
    {
        foreach (PaymentTypeFactory::DEFAULTS as $paymentType) {
            PaymentType::firstOrCreate(
                [
                    'slug' => $paymentType['slug']
                ],
                [
                    'name' => $paymentType['name'],
                ]
            );
        }
    }
}