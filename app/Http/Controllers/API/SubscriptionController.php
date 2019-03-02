<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subscriptions;
use App\User;

class SubscriptionController extends Controller
{
    protected $user;

    public function __construct()
    {
       $this->user = auth()->user();
    }

    public function create(Request $request)
    {

       $stripeToken = $request->stripeToken;

       $this->user->newSubscription('main', 'plan_Ec9wlWrOe78hQL')->create($stripeToken);

       $result = [
           'status' => true,
           'message' => 'subscription created successfully',
           'data' => $this->user
       ];

       return response()->json($result, 201);
    }

    public function cancel()
    {
        $this->user->subscription('main')->cancel();

        $result = [
            'status' => true,
            'message' => 'subscription has been cancelled',
            'data' => $this->user
        ];

        return response()->json($result);
    }

    public function resume()
    {
        $this->user->subscription('main')->resume();

        $result = [
            'status' => true,
            'message' => 'subscription has been resumed',
            'data' => $this->user
        ];

        return response()->json($result);

    }
}
