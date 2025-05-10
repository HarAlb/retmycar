<?php

namespace App\Virtual\Responses;

use OpenApi\Attributes as OAT;

#[OAT\Schema(title: 'User response')]
class UserResponse
{
    #[OAT\Property(title: 'id', example: 2)]
    public int $id;

    #[OAT\Property(title: 'name', example: 'test')]
    public string $name;

    #[OAT\Property(title: 'Email', example: 'example@gmail.com')]
    public string $email;

    #[OAT\Property(title: 'Email Verified time', example: '2025-05-09T22:55:47.000000Z')]
    public string $email_verified_at;

    #[OAT\Property(title: 'Created time', example: '2025-05-09T22:55:47.000000Z')]
    public string $created_at;

    #[OAT\Property(title: 'Updated time', example: '2025-05-09T22:55:47.000000Z')]
    public string $updated_at;
}
