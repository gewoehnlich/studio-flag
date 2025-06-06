<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('studio-flag');

        return response()->json([
            'success' => true,
            'message' => 'Вы успешно зарегистрировались, ' . $user->name . '!',
            'token' => $token->plainTextToken
        ]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Неправильный логин или пароль.'
            ], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('studio-flag');

        return response()->json([
            'success' => true,
            'message' => 'С возвращением, ' . $user->name . '!',
            'token' => $token->plainTextToken
        ]);
    }

    public function logout(LogoutRequest $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось найти пользователя по такому Bearer Token.'
            ], 401);
        }

        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Вы успешно вышли со своего аккаунта, ' . $user->name . '.',
        ]);
    }
}
