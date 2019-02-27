<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\PhoneNumber;
use Illuminate\Http\Request;

class PhoneNumberController extends Controller
{
    public function create(Request $request)
    {
        $user = auth()->user;

        $attributes = $request->only(['number', 'notification_on']);

        $phoneNumber = $user->phoneNumber->create($attributes);

        $result = [
            'status' => true,
            'message' => 'Retrieved phone number ',
            'data' => $phoneNumber
        ];

        return response()->json($result, 201);
    }

    public function edit(PhoneNumber $number)
    {
        $result = [
            'status' => true,
            'message' => 'Retrieved phone number ',
            'data' => $number
        ];

        return response()->json($result);
    }

    public function update(Request $request, PhoneNumber $number)
    {
        $phoneNumber = $number->update($request->only(['number', 'notification_on']));

        $result = [
            'status' => true,
            'message' => 'Phone number has been updated',
            'data' => $phoneNumber
        ];

        return response()->json($result);

    }

    public function delete(PhoneNumber $number)
    {
        $number->delete();

        $result = [
            'status' => true,
            'message' => 'Phone number has been deleted'
        ];

        return response()->json($result);
    }
}
