<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Events\SignUpEvent;
use App\Models\{User, UsersDevices};
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SignUpJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $deviceDetails;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user, array $deviceDetails)
    {
        //
        $this->user = $user;
        $this->deviceDetails = $deviceDetails;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        event(new SignUpEvent($this->user));

        try {
            $this->user->update([
                'device_id' => $this->deviceDetails['device_id'],
            ]);
            Log::info('Device ID to update: ' . $this->deviceDetails['device_id']);
        } catch (\Exception $e) {
            Log::error('Update failed: ' . $e->getMessage());
        }


        try {
            DB::table('users_devices')->insert([
                'user_id' => $this->user->id,
                'device_id' => $this->deviceDetails['device_id'],
                'device_name' => $this->deviceDetails['device_name'],
                'device_os' => $this->deviceDetails['device_os'],
                'device_ip' => $this->deviceDetails['device_ip'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            Log::info('Saving device details to database');
        } catch (\Exception $e) {
            Log::error('Error saving user device details to DB' . $e->getMessage());
        }
    }
}
