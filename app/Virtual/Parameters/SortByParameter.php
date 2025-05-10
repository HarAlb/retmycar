<?php

namespace App\Virtual\Parameters;

use OpenApi\Attributes as OAT;

#[OAT\Parameter(
    name: 'sort_by',
    description: 'Sort By param',
    in: 'query',
    required: false,
    schema: new OAT\Schema(type: 'string')
)]
class SortByParameter {}
