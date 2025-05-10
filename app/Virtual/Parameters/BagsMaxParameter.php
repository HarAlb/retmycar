<?php

namespace App\Virtual\Parameters;

use OpenApi\Attributes as OAT;

#[OAT\Parameter(
    name: 'bags_max',
    description: 'Bags Max',
    in: 'query',
    required: false,
    schema: new OAT\Schema(type: 'string')
)]
class BagsMaxParameter {}
