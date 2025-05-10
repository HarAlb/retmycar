<?php

namespace App\Virtual\Parameters;

use OpenApi\Attributes as OAT;

#[OAT\Parameter(
    name: 'bags_min',
    description: 'Bags Min',
    in: 'query',
    required: false,
    schema: new OAT\Schema(type: 'string')
)]
class BagsMinParameter {}
