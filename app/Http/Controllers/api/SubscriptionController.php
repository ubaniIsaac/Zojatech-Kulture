<?php

namespace App\Http\Controllers\api;

use App\Models\Subscription;
use App\Http\Resources\SubscriptionResources;
use App\Http\Requests\CreateSubscription;
use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use PhpParser\Node\Stmt\TryCatch;

class SubscriptionController extends Controller
{
    use ResponseTrait;
    public function index(): JsonResponse
    {
        $subscriptions = Subscription::all();
        return $this->successResponse('Subscriptions retrieved successfully', SubscriptionResources::collection($subscriptions));
    }

    public function store(CreateSubscription $request): JsonResponse
    {
        try {

            $subscription = Subscription::create($request->validated());

            return $this->successResponse('Subscription created successfully', new SubscriptionResources($subscription), 201);
        } catch (\Throwable $th) {
            return $this->okResponse('Subscription not created' . $th->getMessage());
        }
    }

    public function show(Subscription $subscription): JsonResponse
    {
        return $this->successResponse('Subscription retrieved successfully', new SubscriptionResources($subscription));
    }

    public function update(CreateSubscription $request, Subscription $subscription): JsonResponse
    {
        $data = $request->validated();
        $subscription->update($data);
        return $this->successResponse('Subscription updated successfully', new SubscriptionResources($subscription));
    }

    public function destroy(Subscription $subscription): JsonResponse
    {
        $subscription->delete();
        return $this->successResponse('Subscription deleted successfully');
    }
}
