<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\SigninMail;
use App\Events\SigninEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SigninJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user, array $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            if ($this->user->device_id != $this->data['device_id']) {

                $id = $this->data['device_id'];
                // $id = $this->data['device_id'];
                // event(new SigninEvent($this->user));
                Mail::to($this->user->email)->send(new SigninMail($this->user, $id));
                Log::info('Different device login detected for user: ' . $this->user->id);
            }

        } catch (\Exception $th) {
            Log::error('Error Logging in user' . $th->getMessage());
        }
    }
}
