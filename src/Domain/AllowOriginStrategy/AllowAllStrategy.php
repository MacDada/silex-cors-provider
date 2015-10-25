<?php

namespace JDesrosiers\Silex\Provider\Domain\AllowOriginStrategy;

use JDesrosiers\Silex\Provider\Domain\AllowOriginStrategy;

class AllowAllStrategy implements AllowOriginStrategy
{
    /**
     * @param string $origin
     * @return bool
     */
    public function isOriginAllowed($origin)
    {
        return true;
    }
}
