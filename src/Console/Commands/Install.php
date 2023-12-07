<?php

namespace Payavel\Checkout\Console\Commands;

use Payavel\Orchestration\Console\Commands\Install as Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
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
    protected $description = 'Install and configure payments within the application.';
}
