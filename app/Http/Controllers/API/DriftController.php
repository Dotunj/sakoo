<?php

namespace App\Http\Controllers\API;

use App\DriftToken;
use App\Events\Drift\ConversationStarted;
use App\Http\Controllers\Controller;
use App\Services\Drift;
use App\User;
use Illuminate\Http\Request;

class DriftController extends Controller
{
    protected $api;

    public function __construct(Drift $api)
    {
        $this->api = $api;
    }

    public function setup(Request $request, DriftToken $driftToken)
    {
        $drift = $this->api->fetchAccessToken($request->code);

        $user = User::first();

        $attributes = [
        'access_token' => $drift['access_token'],
        'refresh_token' => $drift['refresh_token'],
        'organization_id' => $drift['orgId'],
        'user_id' => $user->id,
     ];

        $driftAccount = $driftToken->create($attributes);

        return response()->json(compact('driftAccount', 201));
    }

    public function notifyUserConversationStarted(Request $request)
    {
        event(new ConversationStarted($request->all()));
    }
}
