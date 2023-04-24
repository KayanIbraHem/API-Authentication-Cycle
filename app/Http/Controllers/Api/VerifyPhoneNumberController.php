<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Http\Requests\Api\Authentication\VerifyPhoneNumberRequest;


class VerifyPhoneNumberController extends Controller
{
    public function verify(VerifyPhoneNumberRequest $request)
    {
        $validated = $request->validated();
        $user = User::where('phone', $validated['phone'])->first();
        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        }
        if ($user->phone_verification_code !== $validated['code']) {
            return response()->json([
                'message' => 'Invalid verification code.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user->is_verify = 1;
        $user->phone_verification_code = null;
        $user->save();
        return response()->json([
            'message' => 'Phone number verified successfully.',
            'token' => $user->createToken($user->name)->plainTextToken,
            'user' => new UserResource($user),
        ], Response::HTTP_CREATED);
    }
}
