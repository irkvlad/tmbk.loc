<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    /**
     * Имена атрибутов, которые не должны быть обрезаны.
     *
     * @var array
     */
    protected $except = [
        'password',
        'password_confirmation',
    ];
}
