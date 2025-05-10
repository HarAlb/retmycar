<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

class ProfileController extends Controller
{
    #[OAT\Get(
        path: '/profile',
        operationId: 'getProfile',
        summary: 'Get User Profile',
        security: [['bearerAuth' => []]],
        tags: ['Profile'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Success',
                content: new OAT\JsonContent(ref: '#/components/schemas/UserResponse')
            )
        ]
    )]
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    #[OAT\Post(
        path: '/profile/logout',
        operationId: 'logoutUser',
        summary: 'Logout User',
        security: [['bearerAuth' => []]],
        tags: ['Profile'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Success',
                content: new OAT\JsonContent(ref: '#/components/schemas/MessageResponse')
            )
        ]
    )]
    public function logout(): JsonResponse
    {
        request()->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
