<?php

namespace Alvo\Tanda\Console;

use Illuminate\Console\Command;

class Install extends Command
{
    protected $signature = "tanda:install";

    protected $description = "Install Tanda package";

    public function handle()
    {
        $this->info('Installing Tanda...');
        $this->info('Publishing Configuration...');

        $this->call('vendor:publish', [
      '--provider' => "Alvo\Tanda\TandaServiceProvider",
      '--tag' => "tanda-config"
    ]);

        $this->info('Tanda installed successfully.');
    }
}