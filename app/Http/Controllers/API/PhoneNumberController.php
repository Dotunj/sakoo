<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\PhoneNumber;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePhoneNumberRequest;

class PhoneNumberController extends Controller
{
    public function create(CreatePhoneNumberRequest $request)
    {
        $user = auth()->user();

        $attributes = $request->only(['number', 'notification_on']);

        $phoneNumber = $user->phoneNumbers()->create($attributes);

        $result = [
            'status' => true,
            'message' => 'Number has been added',
            'data' => $phoneNumber
        ];

        return response()->json($result, 201);
    }

    public function edit(PhoneNumber $number)
    {
        $this->authorize('touch', $number);

        $result = [
            'status' => true,
            'message' => 'Retrieved phone number ',
            'data' => $number
        ];

        return response()->json($result);
    }

    public function update(Request $request, PhoneNumber $number)
    {
        $this->authorize('touch', $number);

        $attributes = $request->only(['number', 'notification_on']);

        $number->update($attributes);

        $number->fresh();

        $result = [
            'status' => true,
            'message' => 'Phone number has been updated',
            'data' => $number
        ];

        return response()->json($result);

    }

    public function delete(PhoneNumber $number)
    {
        $this->authorize('touch', $number);
        
        $number->delete();

        $result = [
            'status' => true,
            'message' => 'Phone number has been deleted'
        ];

        return response()->json($result);
    }
}
