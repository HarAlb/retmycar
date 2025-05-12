<?php

namespace App\Http\Controllers\User;

use App\Models\Mark;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

class MarkController extends Controller
{
    #[OAT\Get(
        path: '/marks',
        operationId: 'getMarks',
        summary: 'Get marks with models',
        tags: ['Marks'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Success',
                content: new OAT\JsonContent(
                    type: 'array',
                    items: new OAT\Items(ref: '#/components/schemas/MarkResponse')
                )
            )
        ]
    )]
    public function __invoke(): JsonResponse
    {
        return response()->json(
            Mark::query()->select('id', 'name as brand')->with('models')->get()
        );
    }
}
