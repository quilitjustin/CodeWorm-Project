<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class CheckBanStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ban:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the user is still banned';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('status', 'banned')->get();
        foreach ($users as $user) {
            if (Carbon::now()->greaterThanOrEqualTo($user->banned_until)) {
                $user->status = 'active';
                $user->banned_until = null;
                $user->save();
            }
        }
    }
}
