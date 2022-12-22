<?php

namespace rkujawa\LaravelPaymentGateway\Tests;

use Illuminate\Support\Str;
use rkujawa\LaravelPaymentGateway\Models\PaymentProvider;

class AddPaymentProviderCommandTest extends TestCase
{
    /** @test */
    public function add_payment_provider_command_will_prompt_for_missing_arguments()
    {
        $provider = PaymentProvider::factory()->make();

        $name = Str::studly($provider->slug);

        $this->artisan('payment:add-provider')
            ->expectsQuestion('What payment provider would you like to add?', $name)
            ->expectsQuestion("How would you like to identify the {$name} payment provider?", $provider->slug)
            ->assertExitCode(0);

        $this->assertGatewayExists($provider->slug);
    }

    /** @test */
    public function add_payment_provider_command_completes_without_asking_questions_when_providing_the_arguments()
    {
        $provider = PaymentProvider::factory()->make();

        $this->artisan('payment:add-provider', [
                'provider' => Str::studly($provider->slug),
                '--id' => $provider->slug,
            ])
            ->assertExitCode(0);

        $this->assertGatewayExists($provider->slug);
    }

    /** @test */
    public function add_payment_provider_command_with_test_argument_generates_test_gateway()
    {
        $arguments = [
            '--test' => true,
        ];

        $this->artisan('payment:add-provider', $arguments)
            ->expectsQuestion('How would you like to identify the Test payment provider?', 'test')
            ->assertExitCode(0);


        $this->assertGatewayExists('test');
    }

    private function assertGatewayExists(string $id)
    {
        $provider = Str::studly($id);

        $servicePath = app_path('Services/Payment');

        $this->assertTrue(file_exists("{$servicePath}/{$provider}PaymentGateway.php"));
        $this->assertTrue(file_exists("{$servicePath}/{$provider}PaymentResponse.php"));
    }
}
