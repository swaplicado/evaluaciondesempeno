<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SUtils\SManagersFinishReviewin;

class ManagersFinishReviewing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ManagersFinishReviewing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia mail de notificación cuando todos los encargados directos terminen de revisar los objetivos';

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
        SManagersFinishReviewin::finishReviewin();
    }
}
