<?php

namespace App\Virtual\Requests;

use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Auth by password request',
    required: ['email', 'password']
)]
class AuthByPasswordRequest
{
    #[OAT\Property(description: 'Email', example: 'example@gmail.com')]
    public string $email;

    #[OAT\Property(description: 'Password', example: 'password')]
    public string $password;
}
