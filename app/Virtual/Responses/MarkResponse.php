<?php

namespace App\Virtual\Responses;

use OpenApi\Attributes as OAT;

#[OAT\Schema(title: 'Mark response')]
class MarkResponse
{
    #[OAT\Property(title: 'id', example: 2)]
    public int $id;

    #[OAT\Property(title: 'Mark name', example: 'Alfa Romeo')]
    public string $name;

    #[OAT\Property(
        items: new OAT\Items(ref: '#/components/schemas/CarModelResponse'),
    )]
    public array $models;
}
