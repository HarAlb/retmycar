<?php

namespace App\Virtual\Parameters;

use OpenApi\Attributes as OAT;

#[OAT\Parameter(
    name: 'price_min',
    description: 'Price Min param',
    in: 'query',
    required: false,
    schema: new OAT\Schema(type: 'string')
)]
class PriceMinParameter {}
