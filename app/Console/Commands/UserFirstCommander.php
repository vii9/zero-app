<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UserFirstCommander extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:first';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get first User using command demo';

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
        $user = User::first();
        $password = $this->secret('What is the password ?');
        $this->info('User first is :' . $user->email . ' pass ' . $password);
    }
}
