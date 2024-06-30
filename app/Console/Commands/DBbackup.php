<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DBbackup extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
    */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
    */
    protected $description = 'take backup from database';

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
     * @return int
    */
    public function handle()
    {
        $file = new Filesystem;
        $file->cleanDirectory(public_path('backup'));
        
        $filename = 'backup/backup_'.strtotime(now()).'.sql';

        $process = Process::fromShellCommandline("mysqldump --defaults-file=".base_path()."//mysqldump.cnf ". env('DB_DATABASE') ." > ". $filename);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }
    
}
