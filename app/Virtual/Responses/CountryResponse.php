<?php

namespace App\Virtual\Responses;

use OpenApi\Attributes as OAT;

#[OAT\Schema(title: 'Country response')]
class CountryResponse
{
    #[OAT\Property(title: 'id', example: 2)]
    public int $id;

    #[OAT\Property(title: 'Country name', example: 'Afghanistan')]
    public string $country;

    #[OAT\Property(
        items: new OAT\Items(ref: '#/components/schemas/CityResponse'),
    )]
    public array $cities;
}
