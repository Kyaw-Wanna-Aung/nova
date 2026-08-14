<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:255'],
        ]);

        $admin = Admin::query()
            ->where('email', $validated['email'])
            ->first();

        if (
            ! $admin ||
            ! Hash::check($validated['password'], $admin->password)
        ) {
            return ApiResponse::error('Invalid email or password.', 422);
        }

        $token = $admin->createToken(
            $validated['device_name'] ?? 'admin-api'
        )->plainTextToken;

        return ApiResponse::success(
            [
                'admin' => [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'email' => $admin->email,
                    'phone' => $admin->phone,
                ],
                'token' => $token,
                'token_type' => 'Bearer',
            ],
            'Login successful.',
        );
    }

    public function me(Request $request): JsonResponse
    {
        $admin = $request->user();

        return ApiResponse::success(
            [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'phone' => $admin->phone,
            ],
            'Admin profile retrieved successfully.',
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()
            ?->currentAccessToken()
            ?->delete();

        return ApiResponse::success(message: 'Logged out successfully.');
    }

    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:admins,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $validated['password'],
        ]);

        return ApiResponse::success(
            [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'phone' => $admin->phone,
            ],
            'Admin created successfully.',
            201,
        );
    }
}
