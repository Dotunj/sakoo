<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TrialAboutToExpire;

class SendTrialAboutToExpireEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send emails to remind users their trial is about to expire';

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
    public function handle(TrialAboutToExpire $trial)
    {
        $trial->sendEmail();
    }
}
