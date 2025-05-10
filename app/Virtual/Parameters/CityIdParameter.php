<?php

namespace App\Virtual\Parameters;

use OpenApi\Attributes as OAT;

#[OAT\Parameter(
    name: 'city_id',
    description: 'City Id',
    in: 'query',
    required: false,
    schema: new OAT\Schema(type: 'string')
)]
class CityIdParameter {}
