<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Backup;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backupdatabase:execute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to backup database using Backup:: facade';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Backup::export();
    }
}
