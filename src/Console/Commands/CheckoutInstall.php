<?php

namespace Payavel\Checkout\Console\Commands;

use Payavel\Orchestration\Console\Commands\OrchestrateService as Command;

class CheckoutInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkout:install
                            {service=Checkout}
                            {--id=checkout}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the checkout service into the application.';
}
