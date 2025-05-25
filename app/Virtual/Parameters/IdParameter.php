<?php

namespace App\Virtual\Parameters;

use OpenApi\Attributes as OAT;

#[OAT\Parameter(
    name: 'id',
    description: 'ID',
    in: 'path',
    required: true,
    schema: new OAT\Schema(type: 'string'),
    example: 6
)]
class IdParameter
{
}
