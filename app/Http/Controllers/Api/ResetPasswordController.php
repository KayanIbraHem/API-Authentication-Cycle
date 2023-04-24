<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\Authentication\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function resetPassword(ResetPasswordRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();
        if ($user->reset_password_code !== $validated['code']) {
            return response()->json([
                'message' => 'Invalid code.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user->update(['password' => Hash::make($validated['password'])]);
        return response()->json([
            'success' => 'Password has been reset successfully',
        ], Response::HTTP_OK);
    }
}
