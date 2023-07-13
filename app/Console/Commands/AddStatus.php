<?php

namespace App\Console\Commands;

use App\Models\Status;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:addStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add data to table Status';

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
        $data = [
            [
                'name' => 'status_slacking',
                
            ],
            [
                'name' => 'status_done',
                
            ],
            [
                'name' => 'status_late',
                
            ],
            [
                'name' => 'status_unfinished',
                
            ],
        ];

        Status::insert($data);
        $this->info('Done!');
        return 0;
    }

}
