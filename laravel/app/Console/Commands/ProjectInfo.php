<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProjectInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show info about project features';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Project: Feed of the comments');
        $this->newLine();
        $this->info('<strong>Added: </strong> feature CRUD comment entity');
        $this->info('<strong>Added: </strong> feature Broadcasting comment add');
    }
}
