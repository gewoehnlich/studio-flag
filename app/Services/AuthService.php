<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;

abstract class AuthService extends Service
{
    public static function register(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('studio-flag')->plainTextToken;

        return compact('user', 'token');
    }

    public static function login(array $data): array | null
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        $user->tokens()->delete();

        $token = $user->createToken('studio-flag')->plainTextToken;

        return compact('user', 'token');
    }

    public static function logout(User $user): bool
    {
        if (!$user) {
            return false;
        }

        $user->tokens()->delete();

        return true;
    }
}
