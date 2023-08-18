<?php

namespace Payavel\Checkout\Console\Commands;

use Payavel\Serviceable\Console\Commands\Install as Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkout:install
                            {--id= : The service identifier}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and configure payments within the application.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->addArgument('service', 'checkout');

        parent::handle();
    }
}
