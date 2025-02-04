<?php

namespace App\Console\Commands;

use App\Models\SystemLogs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class initialize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically setup the application server.';

    /**
     * Execute the console command.
     */

     protected function rCommand($command)
    {
        $process = proc_open($command, [
            1 => ['pipe', 'w'], // stdout
            2 => ['pipe', 'w'], // stderr
        ], $pipes);

        if (is_resource($process)) {
            while ($line = fgets($pipes[1])) {
                $this->warn($line);
            }

            while ($line = fgets($pipes[2])) {
                $this->error($line);
            }

            fclose($pipes[1]);
            fclose($pipes[2]);

            return proc_close($process);
        }

        return 1;
    }

    public function handle()
    {
        $progress = $this->output->createProgressBar(100);
        $this->info(' ');
        $this->info('Starting the application setup process...');
        $this->warn('Signed by: ' . '~z.z~');

        $progress->start();

        $this->rCommand('git add .');

        // Pulling the latest changes from the repository
        $this->info(' ');
        $this->info('Stashing Changes...');
        $this->info(' ');


        usleep(2000);
        $this->rCommand('git stash');

        $this->info('Installing Updates...');

        for($i = 0; $i < 80; $i++) {
            $progress->advance(1);
            usleep(25000);
        }

        $this->rCommand('git pull');
        usleep(2000);

        exec('composer install', $output, $returnVar);
        $progress->advance(10);
        if ($returnVar !== 0) {
            $this->info(' ');
            $this->error('Composer installation failed!');
            return;
        }

        $this->rCommand('git stash pop');

        $this->rCommand('php artisan serve --port=8080 --host=127.0.0.1');

        $progress->finish();

        $this->info(' ');
        $this->info('App Ready To Launch...');
        $this->info('run "ngrok" to start the api.');
    }
}
