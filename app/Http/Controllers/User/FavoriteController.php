<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

class FavoriteController extends Controller
{
    #[
        OAT\Get(
            path: '/posts/favorites',
            operationId: 'getFavoritePosts',
            summary: 'Get Favorite Posts',
            security: [['bearerAuth' => []]],
            tags: ['Posts'],
            responses: [
                new OAT\Response(
                    response: 200,
                    description: 'Success',
                    content: new OAT\JsonContent(
                        type: 'array',
                        items: new OAT\Items(ref: '#/components/schemas/PostResponse')
                    )
                )
            ]
        )
    ]
    public function index(): JsonResponse
    {
        $posts = auth()->user()->favorites()->with('city.country', 'model.mark', 'images', 'favoritedByUsers', 'user')->latest()->get();

        return response()->json(
            PostResource::collection($posts)
        );
    }

    #[
        OAT\Post(
            path: '/posts/{id}/favorite',
            operationId: 'storeFavorite',
            summary: 'To favorite',
            security: [['bearerAuth' => []]],
            tags: ['Posts'],
            responses: [
                new OAT\Response(
                    response: 200,
                    description: 'Success',
                    content: new OAT\JsonContent(ref: '#/components/schemas/PostResponse')
                ),
                new OAT\Response(
                    response: 422,
                    description: 'Fail',
                    content: new OAT\JsonContent(ref: '#/components/schemas/ValidationMessageResponse')
                ),
            ]
        ),
        OAT\Parameter(ref: '#/components/parameters/id')
    ]
    public function store(int $id): JsonResponse
    {
        $post = Post::query()->findOrFail($id);

        auth()->user()->favorites()->syncWithoutDetaching($id);

        return response()->json(
            PostResource::make($post->refresh()->load('images', 'favoritedByUsers', 'city.country', 'model.mark', 'user'))
        );
    }

    #[
        OAT\Delete(
            path: '/posts/{id}/favorite',
            operationId: 'deleteFavorite',
            summary: 'delete favorite',
            security: [['bearerAuth' => []]],
            tags: ['Posts'],
            responses: [
                new OAT\Response(
                    response: 200,
                    description: 'Success',
                    content: new OAT\JsonContent(ref: '#/components/schemas/PostResponse')
                ),
                new OAT\Response(
                    response: 422,
                    description: 'Fail',
                    content: new OAT\JsonContent(ref: '#/components/schemas/ValidationMessageResponse')
                ),
            ]
        ),
        OAT\Parameter(ref: '#/components/parameters/id')
    ]
    public function destroy(int $id): JsonResponse
    {
        $post = Post::query()->findOrFail($id);

        auth()->user()->favorites()->detach($post->id);

        return response()->json(
            PostResource::make($post->refresh()->load('images','favoritedByUsers', 'city.country', 'model.mark', 'user'))
        );
    }
}
