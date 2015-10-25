<?php

namespace JDesrosiers\Silex\Provider\Domain;

interface AllowOriginStrategy
{
    /**
     * @param string $origin
     * @return bool
     */
    public function isOriginAllowed($origin);
}
