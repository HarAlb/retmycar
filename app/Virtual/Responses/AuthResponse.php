<?php

namespace App\Virtual\Responses;

use OpenApi\Attributes as OAT;

#[OAT\Schema(title: 'Auth response')]
class AuthResponse
{
    #[OAT\Property(title: 'Bearer token', example: '1|iLWBF5RFQ3kNsEf4bRZaW5H5UVGTKB0J62XNHq960a6c7398')]
    public string $token;

    #[OAT\Property(title: 'User Data')]
    public UserResponse $user;
}
