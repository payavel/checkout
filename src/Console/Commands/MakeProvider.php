<?php

namespace Payavel\Checkout\Console\Commands;

use Payavel\Serviceable\Console\Commands\MakeProvider as Command;
use Illuminate\Support\Facades\Artisan;

class MakeProvider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkout:provider
                            {provider? : The payment provider name}
                            {--service=checkout}
                            {--id= : The payment provider identifier}
                            {--fake : Generates a gateway to be used for testing purposes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold a new payment provider\'s gateway and response classes.';
}
