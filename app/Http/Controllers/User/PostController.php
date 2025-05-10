<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OpenApi\Attributes as OAT;

class PostController extends Controller
{
    #[
        OAT\Get(
            path: '/posts',
            operationId: 'getPosts',
            summary: 'Get Posts',
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
        ),
        OAT\Parameter(ref: '#/components/parameters/model_id'),
        OAT\Parameter(ref: '#/components/parameters/city_id'),
        OAT\Parameter(ref: '#/components/parameters/seats_min'),
        OAT\Parameter(ref: '#/components/parameters/seats_max'),
        OAT\Parameter(ref: '#/components/parameters/price_min'),
        OAT\Parameter(ref: '#/components/parameters/price_max'),
        OAT\Parameter(ref: '#/components/parameters/bags_min'),
        OAT\Parameter(ref: '#/components/parameters/bags_max'),
        OAT\Parameter(ref: '#/components/parameters/sort_by'),
        OAT\Parameter(ref: '#/components/parameters/sort_order'),
    ]
    public function index(): JsonResponse
    {
        $query = Post::query()->with('city.country', 'model.mark', 'images');

        $allowedSorts = ['created_at', 'price'];

        $query->when(request()->model_id, function ($query) {
            $query->where('model_id', request()->model_id);
        });

        $query->when(request()->city_id, function ($query) {
            $query->where('city_id', request()->city_id);
        });

        if (request()->sort_by && in_array(request()->sort_by, $allowedSorts)) {
           $query->orderBy(request()->sort_by, request()->sort_order ?? 'desc');
        }

        $query->when(request()->city_id, function ($query) {
            $query->where('city_id', request()->city_id);
        });

        return response()->json(
            PostResource::collection($query->get())
        );
    }

    #[OAT\Post(
        path: '/posts',
        operationId: 'storePosts',
        summary: 'Store Posts',
        security: [['bearerAuth' => []]],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\MediaType(
                mediaType: "multipart/form-data",
                schema: new OAT\Schema(ref: \App\Virtual\Requests\StorePostRequest::class)
            ),
        ),
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
            )
        ]
    )]
    public function store(StorePostRequest $request): JsonResponse
    {
        $post = auth()->user()->posts()->create($request->validated());

        $disk = 'public';

        foreach ($request->file('images') as $item) {
            $extension = $item->getClientOriginalExtension();
            $filename = Str::slug(preg_replace('@\.' . $extension . '$@', '',
                    $item->getClientOriginalName()) . '_' . Str::random(5));
            $path = 'posts/' . $post->id;

            Storage::disk($disk)->put("$path/$filename.$extension", file_get_contents($item), 'public');

            $post->images()->create([
                'disk' => $disk,
                'path' => $path,
                'filename' => "$filename.$extension"
            ]);
        }

        return response()->json(
            PostResource::make($post->refresh()->load('images', 'city.country', 'model.mark'))
        );
    }
}
