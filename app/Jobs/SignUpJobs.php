<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Events\SignUpEvent;
use App\Models\{User, UsersDevices, Referral};
use App\Http\Controllers\api\ReferralController;
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

    public array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user, array $data)
    {
        //
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        event(new SignUpEvent($this->user));

        try {
            $referral_details = Referral::create([
                'referral_code' => ReferralController::genereteReferralCode(),
                'referred_by' => ReferralController::findReferrer($this->data['referred_by']) ? $this->data['referred_by'] : 'Nil',
                'user_id' => $this->user->id,
            ]);
            Log::info('Referral details created' . $referral_details);
        } catch (\Exception $e) {
            Log::error('Error creating referral details' . $e->getMessage());
        }

        try {
            $this->user->update([
                'device_id' => $this->data['device_id'],
                'referral_code' => $referral_details->referral_code,
            ]);
            Log::info('Device ID to update: ' . $this->data['device_id']);
        } catch (\Exception $e) {
            Log::error('Update failed: ' . $e->getMessage());
        }


        try {
            DB::table('users_devices')->insert([
                'user_id' => $this->user->id,
                'device_id' => $this->data['device_id'],
                'device_name' => $this->data['device_name'],
                'device_os' => $this->data['device_os'],
                'device_ip' => $this->data['device_ip'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            Log::info('Saving device details to database');
        } catch (\Exception $e) {
            Log::error('Error saving user device details to DB' . $e->getMessage());
        }
    }
}
