<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

final class AuthenticationController extends Controller
{
    public static function register(RegisterRequest $request): JsonResponse
    {
        $result = AuthService::register($request->validated());

        $cart = CartService::store($result['user']['id']);

        return response()->json([
            'success' => true,
            'message' => 'Вы успешно зарегистрировались!',
            'user' => new UserResource($result['user']),
            'token' => $result['token']
        ]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = AuthService::login($request->validated());

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Неправильный логин или пароль.'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Вы успешно вошли в свой аккаунт!',
            'user' => new UserResource($result['user']),
            'token' => $result['token']
        ]);
    }

    public function logout(LogoutRequest $request): JsonResponse
    {
        $user = $request->user();

        $result = AuthService::logout($user);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось найти пользователя по такому Bearer Token.'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Вы успешно вышли со своего аккаунта!',
            'user' => new UserResource($user)
        ]);
    }
}
