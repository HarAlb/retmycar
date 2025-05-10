<?php

namespace App\Virtual\Parameters;

use OpenApi\Attributes as OAT;

#[OAT\Parameter(
    name: 'seats_min',
    description: 'Seats Min param',
    in: 'query',
    required: false,
    schema: new OAT\Schema(type: 'string')
)]
class SeatsMinParameter {}
