<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\{Referral, User};
use App\Traits\ResponseTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    use ResponseTrait;

    public static function genereteReferralCode(): string
    {
        $referralCode = strtoupper(Str::random(4));
        $code = 'KULTURE' . $referralCode;

        return $code;
    }

    public static function findReferrer(string $referralCode ): bool
    {
        $referral = Referral::where('referral_code', $referralCode)->first();

        

        if ($referral) {
            $referral->referral_count += 1;
            $referral->save();
            return true;
        }

        return false;
    }
}
