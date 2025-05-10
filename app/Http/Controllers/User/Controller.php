<?php

namespace App\Http\Controllers\User;

use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OAT;

#[
    OAT\Info(version: '1.0', title: 'Rent My car'),
    OAT\Server(url: L5_SWAGGER_CONST_HOST, description: 'API Server'),
    OAT\SecurityScheme(securityScheme: 'bearerAuth', type: 'http', scheme: 'bearer'),
    OAT\SecurityScheme(securityScheme: 'bearerUserAuth', type: 'http', scheme: 'bearer'),
]
class Controller extends BaseController
{
}
