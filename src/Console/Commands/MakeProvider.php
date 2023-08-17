<?php

namespace Payavel\Checkout\Console\Commands;

use Illuminate\Console\Command;
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
                            {--id= : The payment provider identifier}
                            {--fake : Generates a gateway to be used for testing purposes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold a new payment provider\'s gateway and response classes.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('service:provider', [
            'provider' => $this->argument('provider'),
            '--service' => 'checkout',
            '--id' => $this->option('id'),
            '--fake' => $this->option('fake', false),
        ]);
    }
}
