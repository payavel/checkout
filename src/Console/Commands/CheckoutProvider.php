<?php

namespace Payavel\Checkout\Console\Commands;

use Payavel\Orchestration\Console\Commands\OrchestrateProvider as Command;

class CheckoutProvider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkout:provider
                            {provider? : The checkout provider name}
                            {--id= : The checkout provider ID}
                            {--service=checkout}
                            {--fake : Generates a gateway to be used for testing purposes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold a new checkout provider\'s gateway and response classes.';
}
