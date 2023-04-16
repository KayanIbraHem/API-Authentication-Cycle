<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Api\UserResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $validateUser = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validateUser->fails()) {
            return response()->json([
                'message' => 'Error',
                'errors' => $validateUser->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'message' => 'User Created successfully,please verify phone number',
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $validateLogin = Validator::make($request->all(), [
            'email' => 'email',
            'email_or_phone' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ]);
        if ($validateLogin->fails()) {
            return response()->json([
                'message' => 'Error',
                'errors' => $validateLogin->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $credentials = $request->only('email_or_phone', 'password');
        $field = filter_var($credentials['email_or_phone'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $user = User::where($field, $credentials['email_or_phone'])->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'error' => 'invalid data',
            ]);
        }
        if ($user->is_verify !== 1) {
            return response()->json([
                'error' => 'please verfiy phone number first!',
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'message' => 'Loged in successfully',
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'user' => new UserResource($user),
        ], Response::HTTP_OK);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'new_password' => 'required',
            'new_confirm_password' => 'same:new_password',
        ]);
        if (!Hash::check($request->password, auth()->user()->password)) {
            return response()->json([
                'message' => 'Error',
                'errors' => 'The current password is incorrect'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
        return response()->json([
            'success' => 'Password has been changed successfully',
        ], Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->tokens()->delete();
        return response()->json([
            'message' => 'logout successfully',
        ], Response::HTTP_OK);
    }
}
