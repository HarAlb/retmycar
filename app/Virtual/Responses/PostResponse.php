<?php

namespace App\Virtual\Responses;

use OpenApi\Attributes as OAT;

#[OAT\Schema(title: 'Post response')]
class PostResponse
{
    #[OAT\Property(title: 'id', example: 2)]
    public int $id;

    #[OAT\Property(description: 'City')]
    public PostCityResponse $city;

    #[OAT\Property(description: 'User')]
    public UserShortResponse $user;

    #[OAT\Property(description: 'Model')]
    public PostModelResponse $model;

    #[OAT\Property(title: 'Seats', example: 4)]
    public int $seats;

    #[OAT\Property(title: 'Price', example: 10.2)]
    public float $price;

    #[OAT\Property(title: 'transmission', example: 'automatic')]
    public string $transmission;

    #[OAT\Property(title: 'Fuel', example: 'gasoline')]
    public string $fuel;

    #[OAT\Property(title: 'Fuel', items: new OAT\Items(ref: '#/components/schemas/ImageResponse'))]
    public array $images;

    #[OAT\Property(title: 'Is favorite', example: true)]
    public bool $is_favorite;
}
