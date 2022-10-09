<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationDataRequest;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return new JsonResponse(['token' => Auth::user()->createToken("login_on_{$request->header('User-Agent')}")->plainTextToken]);
        }

        return new JsonResponse([__("auth.failed")], 401);
    }

    public function register(UserRegistrationDataRequest $request)
    {
        $user = new User([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'gender' => $request->gender,
            'about_me' => $request->about_me
        ]);

        $user->saveOrFail();

        return new JsonResponse([__('auth.register_success')]);
    }

    public function user(Request $request): JsonResponse
    {
        return new JsonResponse($request->user());
    }
}
