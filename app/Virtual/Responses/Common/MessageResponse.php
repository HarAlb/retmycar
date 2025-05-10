<?php

namespace App\Virtual\Responses\Common;

use OpenApi\Attributes as OAT;

#[OAT\Schema(title: 'Message response')]
class MessageResponse
{
    #[OAT\Property(title: 'message', example: 'Error')]
    public string $message;
}
