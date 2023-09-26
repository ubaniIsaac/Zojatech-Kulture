<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Events\SignUpEvent;
use App\Models\{Producer, User, Referral};
use App\Http\Controllers\api\ReferralController;
use Illuminate\Support\Facades\{DB, Log};
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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

        //Get and create referral details
        try {
            if ($this->user->user_type === 'producer') {
                $this->user->producers()->create(['user_id' => $this->user->id]);
            } else if ($this->user->user_type === 'artiste') {
                $this->user->artistes()->create(['user_id' => $this->user->id]);
            }

            $referral_details = Referral::create([
                'referral_code' => ReferralController::genereteReferralCode(),
                'referred_by' => ReferralController::findReferrer($this->data['referred_by'], $this->user) ? $this->data['referred_by'] : 'Nil',
                'user_id' => $this->user->id,
            ]);


            $subscription = DB::table('subscriptions')->where('plan', 'Free Plan')->first();

            print_r($subscription);

            if ($subscription) {
                //find user in the producers table
                $producer = Producer::where('user_id', $this->user->id)->first();

                if ($producer) {
                    $producer = $producer->update([
                        'subscription_id' => $subscription->id,
                        'subscription_status' => 'active',
                        'subscription_plan' => $subscription->plan,
                    ]);
                }
            }
            Log::info('Referral details created' . $referral_details);
        } catch (\Throwable $e) {
            Log::error('Error creating referral details' . $e->getMessage());
        }



        //Update user with referral code and device id
        try {
            $this->user->update([
                'device_id' => $this->data['device_id'],
                'referral_code' => $referral_details->referral_code,
            ]);
            Log::info('Device ID to update: ' . $this->data['device_id']);
        } catch (\Throwable $e) {
            Log::error('Update failed: ' . $e->getMessage());
        }

        //Save device details to database
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
        } catch (\Throwable $e) {
            Log::error('Error saving user device details to DB' . $e->getMessage());
        }
    }
}
