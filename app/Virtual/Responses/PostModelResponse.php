<?php

namespace App\Virtual\Responses;

use OpenApi\Attributes as OAT;

#[OAT\Schema(title: 'Post City response')]
class PostModelResponse
{
    #[OAT\Property(title: 'id', example: 2)]
    public int $id;

    #[OAT\Property(title: 'City', example: 'Kabul')]
    public string $name;

    #[
        OAT\Property(
            properties: [
                'id' => new OAT\Property(
                    property: 'id',
                    description: 'ID Country',
                    type: 'integer',
                    example: 1
                ),
                'name' => new OAT\Property(
                    property: 'name',
                    description: 'Mark',
                    type: 'string',
                    example: 'Alfa Romeo'
                ),
            ]
        )
    ]
    public object $mark;
}
