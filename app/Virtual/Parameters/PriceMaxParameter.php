<?php

namespace App\Virtual\Parameters;

use OpenApi\Attributes as OAT;

#[OAT\Parameter(
    name: 'price_max',
    description: 'Price Max param',
    in: 'query',
    required: false,
    schema: new OAT\Schema(type: 'string')
)]
class PriceMaxParameter {}
