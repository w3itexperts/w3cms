<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ResetDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the database using a custom SQL script';

    /**
     * Execute the console command.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sqlScriptPath = storage_path('db-reset-sql.sql');

        // Tables that must NOT be touched
        $protectedTables = [
            'cities',
            'states',
            'countries',
        ];

        if (!File::exists($sqlScriptPath)) {
            $this->error("SQL file not found: {$sqlScriptPath}");
            return Command::FAILURE;
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            $this->info('Dropping all tables...');
            $this->dropAllTables($protectedTables);

            $this->info('Importing SQL file...');
            DB::unprepared(File::get($sqlScriptPath));

            $this->info('Database reset successfully.');

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Database reset failed: ' . $e->getMessage());

            return Command::FAILURE;
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    // Function to drop all tables in the database
    protected function dropAllTables($protectedTables=[])
    {
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $tableName = reset($table);
            if (in_array($tableName, $protectedTables)) {
                continue;
            }
            DB::statement("DROP TABLE IF EXISTS $tableName");
        }
    }
}
