<?php

namespace App\Console\Commands;
use App\Models\User;
use App\Jobs\SendWelcomeMail;
use Illuminate\Console\Command;

class SignUpCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sign-up-commands {user} {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = $this->argument('user');
        $data = $this->argument('data');

        SendWelcomeMail::dispatch($user);
    }
}
