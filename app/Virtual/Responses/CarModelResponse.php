<?php

namespace App\Virtual\Responses;

use OpenApi\Attributes as OAT;

#[OAT\Schema(title: 'Car Model response')]
class CarModelResponse
{
    #[OAT\Property(title: 'id', example: 2)]
    public int $id;

    #[OAT\Property(title: 'Car model name', example: 'Giulia')]
    public string $name;

    #[OAT\Property(title: 'Mark id', example: 2)]
    public int $mark_id;
}
