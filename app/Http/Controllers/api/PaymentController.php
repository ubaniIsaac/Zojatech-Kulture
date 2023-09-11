<?php

namespace App\Http\Controllers\api;

use App\Http\Requests\PaymentRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResources;
use App\Models\Beat;
use App\Models\Payment;
use App\Models\Producer;
use App\Models\Cart;
use App\Models\User;
use App\Services\PaymentService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class PaymentController extends Controller
{
    use ResponseTrait;

    //
    public PaymentService $paymentService;
    public function __construct()
    {

        $this->paymentService = app(PaymentService::class);
    }


    public function makePayment(Request $request): JsonResponse
    {
        $user = auth()->user();
        $ref = uniqid();
        $cart = Cart::where('user_id', $user->id)->first();
        if (count($cart->items) == 0) {
            return $this->errorResponse('Nothing in cart');
        }
        $data = [
            'amount' => $user->cart->total_price,
            'email' => $user?->email,
            'user_id' => $user?->id,
            'cart_id' => $cart->id,
            'cart_items' => $user->cart->items,
            'reference' => $ref,
            'callback_url' => $request->baseUrl . "/verify-payment"
        ];

        Payment::create(Arr::except($data, ['callback_url', 'email']));

        $result = $this->paymentService->initializePayment($data);

        return response()->json([
            'status' => true,
            'message' => 'Payment initialzed',
            'data' => $result,
            'reference' => $ref,

        ], 200);
    }

    public function verifyPayment(Request $request): JsonResponse
    {
        try {
            $response =  $this->paymentService->verifyPayment($request->reference);
            if($response['status'] == "abandoned"){
                return response()->json([
                    "message" => "Payament not complete",
                    "reference"=> $request->reference
                ], 400);
            };
            if ($response['status'] == true) {
                $payment = Payment::where('reference', $request->reference)->first();
                $user = $payment->user;


                if ($payment?->status == 'successful') {
                    return response()->json([
                        "message" => "Payment already verified",
                        "data" =>  $payment,
                    ], 409);
                }

                $payment->status = 'successful'; // @phpstan-ignore-line
                $payment?->save();

                // disburse funds / update all producers' wallet / update Admin wallet. 
                $cart = Cart::findorfail($payment->cart_id);
                foreach ($cart->items as $item) {
                    //update beat details. 
                    $beat = Beat::findorfail($item);
                    $beat->producer->total_revenue += $beat->price;
                    $beat->producer->increment('total_beats_sold');
                    $beat->increment('total_sales');
                    $beat->decrement('available_copies');
                    $cart->user->artistes->increment('beats_purchased');
                    $cart->user->artistes->total_amount_spent += $beat->price;
                    $beat->save();
                    $beat->producer->save();
                }

                //empty cart
                $cart->update(['items' => [], 'total_price' => 0]);
                $token = $user->generateToken();
                $token = $user->createToken($user->email, [$user->user_type])->accessToken;

                return $this->successResponse('Payment Successful', [
                    'token' => $token,
                    'user' => new UserResources($user),
                    'status' => "successful"
                ]);
            }
            return response()->json([
                "message" => "Payment not complete",
                'status' => 400
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
                'status' => 302
            ], 302);
        }
    }

    //Handles withdrawals
    public function createRecipient(Request $request): JsonResponse
    {

        $user = User::findorfail(auth()->user()->id);

        $ref = uniqid();
        $data = [
            'name' => $request['name'],
            'bank_code' => $request['bank_code'],
            'account_number' => $request['account_number'],
        ];

        $result = $this->paymentService->createRecipient($data);

        $user->recipient_code = $result['recipient_code'];
        $user->save();

        return $this->successResponse('Account details uploaded successfully');
    }

    public function initiateWithdrawal(Request $request): JsonResponse
    {
        $user = User::findorfail(auth()->user()->id);
        $producer = Producer::where('user_id', $user->id)->first();

        if ($producer->total_revenue < $request['amount']) {
            return $this->errorResponse('Insufficient balance');
        }

        $data = [
            'recipient' => $user->recipient_code,
            'amount' => $request['amount']
        ];

        $result = "withrawal"; //mock($this->paymentService->initiateWithdrawal($data));

        if ($result) {
            $producer->total_revenue -= $request['amount'];
            $producer->save();
            // dd($producer);
        }
        return $this->successResponse('Withdrawal initiated successfully', $producer);
    }
}
