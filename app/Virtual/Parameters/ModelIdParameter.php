<?php

namespace App\Virtual\Parameters;

use OpenApi\Attributes as OAT;

#[OAT\Parameter(
    name: 'model_id',
    description: 'Model Id',
    in: 'query',
    required: false,
    schema: new OAT\Schema(type: 'string')
)]
class ModelIdParameter {}
