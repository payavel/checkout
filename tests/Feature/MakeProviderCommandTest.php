<?php

namespace Payavel\Checkout\Tests;

use Illuminate\Support\Str;
use Payavel\Serviceable\Models\Provider;

class MakeProviderCommandTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('serviceable.services.checkout', [
            'name' => 'Checkout',
            'config' => 'payment',
        ]);
    }

    /** @test */
    public function make_payment_provider_command_will_prompt_for_missing_arguments()
    {
        $provider = Provider::factory()->make();

        $this->artisan('checkout:provider')
            ->expectsQuestion('What checkout provider would you like to add?', $provider->name)
            ->expectsQuestion("How would you like to identify the {$provider->name} checkout provider?", $provider->id)
            ->expectsOutput("{$provider->name} checkout gateway generated successfully!")
            ->assertExitCode(0);

        $this->assertGatewayExists($provider->id);
    }

    /** @test */
    public function make_payment_provider_command_completes_without_asking_questions_when_providing_the_arguments()
    {
        $provider = Provider::factory()->make();

        $this->artisan('checkout:provider', [
                'provider' => $provider->name,
                '--id' => $provider->id,
            ])
            ->expectsOutput("{$provider->name} checkout gateway generated successfully!")
            ->assertExitCode(0);

        $this->assertGatewayExists($provider->id);
    }

    /** @test */
    public function make_payment_provider_command_with_fake_argument_generates_fake_gateway()
    {
        $arguments = [
            '--fake' => true,
        ];

        $this->artisan('checkout:provider', $arguments)
            ->expectsOutput('Fake checkout gateway generated successfully!')
            ->assertExitCode(0);

        $this->assertGatewayExists('fake');
    }

    private function assertGatewayExists(string $id)
    {
        $provider = Str::studly($id);

        $servicePath = app_path('Services/Checkout');

        $this->assertTrue(file_exists("{$servicePath}/{$provider}CheckoutRequest.php"));
        $this->assertTrue(file_exists("{$servicePath}/{$provider}CheckoutResponse.php"));
    }
}
