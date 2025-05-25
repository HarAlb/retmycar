<?php

namespace App\Virtual\Responses;

use OpenApi\Attributes as OAT;

#[OAT\Schema(title: 'User Short response')]
class UserShortResponse
{
    #[OAT\Property(title: 'id', example: 2)]
    public int $id;

    #[OAT\Property(title: 'name', example: 'test')]
    public string $name;

    #[OAT\Property(title: 'Email', example: 'example@gmail.com')]
    public string $email;
}
