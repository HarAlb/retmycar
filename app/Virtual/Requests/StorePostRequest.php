<?php

namespace App\Virtual\Requests;

use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Store Post request',
    required: ['model_id', 'city_id', 'seats', 'price', 'transmission', 'fuel']
)]
class StorePostRequest
{
    #[OAT\Property(description: 'Car Model ID', example: 1)]
    public int $model_id;

    #[OAT\Property(description: 'City ID', example: 1)]
    public int $city_id;

    #[OAT\Property(description: 'Seats', example: '3')]
    public int $seats;

    #[OAT\Property(description: 'Price', example: 1.20)]
    public float $price;

    #[OAT\Property(description: 'Transmission', example: 'automatic|manual')]
    public string $transmission;

    #[OAT\Property(description: 'Fuel', example: 'gasoline|petrol')]
    public string $fuel;

    #[OAT\Property(
        property: 'images[]',
        description: 'Images',
        type: 'array',
        items: new OAT\Items(type: 'string', format: 'binary')
    )]
    public $images;
}
