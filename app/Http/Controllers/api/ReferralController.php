<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\{Referral, User, Producer};
use App\Traits\ResponseTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReferralController extends Controller
{
    use ResponseTrait;

    public static function genereteReferralCode(): string
    {
        $referralCode = strtoupper(Str::random(4));
        $code = 'KULTURE' . $referralCode;

        return $code;
    }

    public static function findReferrer(string $referralCode, User $user): bool
    {
        $referral = Referral::where('referral_code', $referralCode)->first();

        if ($referral) {
            $referral->referral_count += 1;
            $referral->save();  

            $producer = Producer::where('user_id', $referral->user_id)->first();

            if(!$producer) {
                Log::info('User is not a producer');
            }

            if ($producer) {
                $producer->upload_limit += 3;
                $producer->save();
                Log::info('Producer upload limit updated');
            }

            return true;
        }

        return false;
    }
}
