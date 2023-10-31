<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\{Referral, User, Producer};
use App\Traits\ResponseTrait;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ReferralController extends Controller
{
    use ResponseTrait;
    public function index(): JsonResponse
    {
        $referrals = Referral::orderBy('referral_count', 'desc')->paginate(5);
 

        return $this->successResponse('Referrals found', $referrals, 200);
    }

    public static function genereteReferralCode(): string
    {
        $referralCode = strtoupper(Str::random(4));
        $code = 'KULTURE' . $referralCode;

        return $code;
    }

    public static function findReferrer(string $referralCode, User $user): bool
    {
        if($referralCode == '') {
            return false;
        }   

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

    public function getUserDetails(string $id): JsonResponse
    {   
        $referral_details = Referral::where('user_id', $id)->first();

       
        return $this->successResponse('Referral details found', $referral_details);
    }

    public function getCodeDetails(string $code): JsonResponse
    {
        $referral_details = Referral::where('referral_code', $code)->first();

        if(!$referral_details) {
            return $this->errorResponse('Referral details not found', null, 404);
        }

        return $this->successResponse('Referral details found', $referral_details);
    }
}
