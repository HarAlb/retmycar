<?php

namespace App\Virtual\Responses\Common;

use OpenApi\Attributes as OAT;

#[OAT\Response(
    response: 'noContent',
    description: 'No content',
    content: new OAT\JsonContent()
)]
class NoContentResponse
{
}
