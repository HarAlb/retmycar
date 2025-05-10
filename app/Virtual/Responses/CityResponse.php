<?php

namespace App\Virtual\Responses;

use OpenApi\Attributes as OAT;

#[OAT\Schema(title: 'City response')]
class CityResponse
{
    #[OAT\Property(title: 'id', example: 2)]
    public int $id;

    #[OAT\Property(title: 'City', example: 'Kabul')]
    public string $name;

    #[OAT\Property(title: 'Country id', example: 2)]
    public int $country_id;
}
