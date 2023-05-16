<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Authentication\CheckCodeRequest;

class CheckPasswordCode extends Controller
{
    public function checkCode(CheckCodeRequest $request)
    {
        $validated = $request->validated();
        $user = User::where('email', $validated['email'])->first();
        if ($user->reset_password_code !== $validated['code']) {
            return response()->json([
                'message' => 'Invalid code.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user->reset_password_code=null;
        $user->save();
        return response()->json([
            'success' => 'The verification code is correct',
        ], Response::HTTP_OK);
    }
}
