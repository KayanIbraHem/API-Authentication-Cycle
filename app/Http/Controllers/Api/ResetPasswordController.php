<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|numeric',
            'password' => 'required|confirmed|max:60'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'message' => 'Error',
                'errors' => $validation->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        }
        if ($user->reset_password_code !== $request->code) {
            return response()->json([
                'message' => 'Invalid code.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user->update(['password' => Hash::make($request->password)]);
        return response()->json([
            'success' => 'Password has been reset successfully',
        ], Response::HTTP_OK);
    }
}
