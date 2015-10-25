<?php

namespace Domain\AllowOriginStrategy;

use JDesrosiers\Silex\Provider\Domain\AllowOriginStrategy;

class AllowNoneStrategy implements AllowOriginStrategy
{
    /**
     * @param string $origin
     * @return bool
     */
    public function isOriginAllowed($origin)
    {
        return false;
    }
}
