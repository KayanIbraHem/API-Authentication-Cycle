<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Authentication\ForgotPasswordRequest;


class ForgotPasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $validated = $request->validated();
        $user = User::where('email', $validated['email'])->first();
        $user->reset_password_code = 2222;
        $user->save();
        return response()->json([
            'message' => 'Reset code sent'
        ]);
    }
}
