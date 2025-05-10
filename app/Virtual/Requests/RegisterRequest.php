<?php

namespace App\Virtual\Requests;

use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Auth by password request',
    required: ['name', 'email', 'password']
)]
class RegisterRequest
{
    #[OAT\Property(description: 'Name', example: 'My name')]
    public string $name;

    #[OAT\Property(description: 'Email', example: 'example@gmail.com')]
    public string $email;

    #[OAT\Property(description: 'Password', example: 'password')]
    public string $password;

    #[OAT\Property(description: 'Password Confirmed', example: 'password')]
    public string $password_confirmed;
}
