<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OAT;

class AuthController extends Controller
{
    #[OAT\Post(
        path: '/auth/login',
        operationId: 'loginUser',
        summary: 'SignIn User',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(
                ref: '#/components/schemas/AuthByPasswordRequest'
            )
        ),
        tags: ['Auth'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Success',
                content: new OAT\JsonContent(ref: '#/components/schemas/AuthResponse')
            ),
            new OAT\Response(
                response: 422,
                description: 'Fail',
                content: new OAT\JsonContent(ref: '#/components/schemas/ValidationMessageResponse')
            )
        ]
    )]
    public function login(AuthRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->validated())) {
            throw ValidationException::withMessages([
                'email' => ['Login failed']
            ]);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'token' => $user->createToken('api')->plainTextToken,
            'user' => $user
        ]);
    }

    #[OAT\Post(
        path: '/auth/register',
        operationId: 'registerUser',
        summary: 'SignUP User',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(
                ref: '#/components/schemas/RegisterRequest'
            )
        ),
        tags: ['Auth'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Success',
                content: new OAT\JsonContent(ref: '#/components/schemas/AuthResponse')
            ),
            new OAT\Response(
                response: 422,
                description: 'Fail',
                content: new OAT\JsonContent(ref: '#/components/schemas/ValidationMessageResponse')
            )
        ]
    )]
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::query()->create($request->validated());

        return response()->json([
            'token' => $user->createToken('api')->plainTextToken,
            'user' => $user
        ]);
    }
}
