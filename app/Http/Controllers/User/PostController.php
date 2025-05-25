<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
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
        $query = Post::query()->with('city.country', 'model.mark', 'images', 'favoritedByUsers', 'user');

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
            PostResource::make($post->refresh()->load('images', 'favoritedByUsers', 'city.country', 'model.mark', 'user'))
        );
    }

    #[
        OAT\Put(
            path: '/posts/{id}',
            operationId: 'updatePost',
            summary: 'Update Posts',
            security: [['bearerAuth' => []]],
            requestBody: new OAT\RequestBody(
                required: true,
                content: new OAT\MediaType(
                    mediaType: "multipart/form-data",
                    schema: new OAT\Schema(ref: \App\Virtual\Requests\UpdateRequest::class)
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
                ),
                new OAT\Response(
                    response: 404,
                    description: 'Not found',
                    content: new OAT\JsonContent(ref: '#/components/schemas/MessageResponse')
                )
            ]
        ),
        OAT\Parameter(ref: '#/components/parameters/id')
    ]
    public function update(int $id, UpdatePostRequest $request): JsonResponse
    {
        $post = auth()->user()->posts()->findOrFail($id);

        $post->update($request->validated());

        $disk = 'public';

        $saveImageIds = array_values($request->save_image_ids ?? []);

        $imagesForDelete = $post->images()->whereNotIn('id', $saveImageIds)->get();

        foreach ($imagesForDelete as $item){
            Storage::disk($disk)->delete("$item->path/$item->filename");

            $item->destroy();
        }

        foreach ($request->file('images') ?? [] as $item) {
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
            PostResource::make($post->refresh()->load('images', 'favoritedByUsers', 'city.country', 'model.mark', 'user'))
        );
    }

    #[
        OAT\Delete(
            path: '/posts/{id}',
            operationId: 'deletePost',
            summary: 'Delete Posts',
            security: [['bearerAuth' => []]],
            tags: ['Posts'],
            responses: [
                new OAT\Response(ref: '#/components/responses/noContent', response: 204),
                new OAT\Response(
                    response: 404,
                    description: 'Not found',
                    content: new OAT\JsonContent(ref: '#/components/schemas/MessageResponse')
                )
            ]
        ),
        OAT\Parameter(ref: '#/components/parameters/id')
    ]
    public function destroy(int $id): Response
    {
        $post = auth()->user()->posts()->findOrFail($id);

        $imagesForDelete = $post->images()->get();

        $disk = 'public';

        foreach ($imagesForDelete as $item){
            Storage::disk($disk)->delete("$item->path/$item->filename");

            $item->destroy();
        }

        $post->destroy();

        return response()->noContent();
    }
}
