<?php

namespace JDesrosiers\Silex\Provider\Domain;

use Symfony\Component\HttpFoundation\Request;

class Cors
{
    /**
     * @param Request $request
     * @return bool
     */
    public function isCorsRequest(Request $request)
    {
        return $request->headers->has('Origin');
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function isPreflightRequest(Request $request)
    {
        return 'OPTIONS' === $request->getMethod() && $request->headers->has('Access-Control-Request-Method');
    }
}
