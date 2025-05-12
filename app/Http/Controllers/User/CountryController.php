<?php

namespace App\Http\Controllers\User;

use App\Models\Country;
use App\Models\Mark;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

class CountryController extends Controller
{
    #[OAT\Get(
        path: '/countries',
        operationId: 'getCountries',
        summary: 'Get Countries with cities',
        tags: ['Country'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Success',
                content: new OAT\JsonContent(
                    type: 'array',
                    items: new OAT\Items(ref: '#/components/schemas/CountryResponse')
                )
            )
        ]
    )]
    public function __invoke(): JsonResponse
    {
        return response()->json(
            Country::query()->select('id', 'name as county')->with('cities')->get()
        );
    }
}
