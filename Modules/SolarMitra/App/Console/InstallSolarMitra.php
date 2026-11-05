<?php

namespace Modules\SolarMitra\App\Console;

use Illuminate\Console\Command;
use Modules\SolarMitra\Lib\SolarMitraInstaller;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InstallSolarMitra extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'solarmitra:install';

    /**
     * The console command description.
     */
    protected $description = 'Install the SolarMitra module.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(SolarMitraInstaller $installer)
    {
        $this->info('Installing SolarMitra...');
        $this->newLine();

        try {
            $installer->install();

            $this->newLine();
            $this->info('SolarMitra installed successfully.');

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->newLine();
            $this->error('SolarMitra installation failed.');
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
