<?php

namespace App\Http\Middleware;

use Filament\Http\Middleware\Authenticate;

class FillamentAuthPublisher extends Authenticate
{
    protected static $ROUTE_LOGIN = '/publisher/login';

    /**
     * @override the filament authenticate - redirectTo function
     * */
    protected function redirectTo($request): ?string
    {
        return self::$ROUTE_LOGIN;
    }
}
