<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Api\UserResource;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Api\Authentication\LoginRequest;
use App\Http\Requests\Api\Authentication\RegisterRequest;
use App\Http\Requests\Api\Authentication\ChangePasswordRequest;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'phone_verification_code' => 1111,
        ]);
        return response()->json([
            'message' => 'User Created successfully,please verify phone number',
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        // $validated = $request->validated();
        $credentials = $request->only('email_or_phone', 'password');
        $field = filter_var($credentials['email_or_phone'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $user = User::where($field, $credentials['email_or_phone'])->first();
        //Another way
        // $user = User::where(function ($query) use ($validated) {
        //     $query->where('email', $validated['email_or_phone'])
        //         ->orWhere('phone', $validated['email_or_phone']);
        // })->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'error' => 'invalid data',
            ]);
        }
        if ($user->is_verify !== 1) {
            return response()->json([
                'error' => 'please verfiy phone number first!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'message' => 'Loged in successfully',
            'token' => $user->createToken($user->name)->plainTextToken,
            'user' => new UserResource($user),
        ], Response::HTTP_OK);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $validated = $request->validated();
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return response()->json([
                'message' => 'The current password is wrong'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        User::find(auth()->user()->id)->update(['password' => Hash::make($validated['new_password'])]);
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
