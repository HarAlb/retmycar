<?php

namespace App\Virtual\Responses;

use OpenApi\Attributes as OAT;

#[OAT\Schema(title: 'Image response')]
class ImageResponse
{
    #[OAT\Property(title: 'id', example: 2)]
    public int $id;

    #[OAT\Property(title: 'Path', example: 'http://rentmy-car.test/storage/posts/9/screenshot-2025-05-06-110442-zugga.png')]
    public string $path;
}
