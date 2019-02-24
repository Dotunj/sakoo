<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Drift;
use App\DriftToken;

class DriftController extends Controller
{
   protected $api;

   public function __construct(Drift $api)
   {
      $this->api = $api;
   }

   public function setup(Request $request, DriftToken $driftToken)
   {
     $driftToken = $this->api->fetchAccessToken($request->code);

     $attributes = [
        'access_token' => $driftToken['access_token'],
        'refresh_token' => $driftToken['refresh_token'],
        'organization_id' => $driftToken['orgId'],
        'user_id' => $request->user()->id,
     ];

     $driftAccount = $driftToken->create($attributes);

     return response()->json(compact('driftAccount', 201));
   }
}
