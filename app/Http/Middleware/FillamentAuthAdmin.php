<?php

namespace App\Http\Middleware;

use Filament\Http\Middleware\Authenticate;

class FillamentAuthAdmin extends Authenticate
{
    protected static $ROUTE_LOGIN = '/admin/login';

    /**
     * @override the filament authenticate - redirectTo function
     * */
    protected function redirectTo($request): ?string
    {
        return self::$ROUTE_LOGIN;
    }
}
