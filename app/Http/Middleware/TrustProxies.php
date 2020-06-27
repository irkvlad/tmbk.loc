<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * Доверенные прокси для этого приложения.
     *
     * @var array|string
     */
    protected $proxies;

    /**
     * Заголовки, которые должны использоваться для обнаружения прокси.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
