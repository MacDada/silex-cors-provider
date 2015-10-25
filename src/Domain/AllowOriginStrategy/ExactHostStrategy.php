<?php

namespace JDesrosiers\Silex\Provider\Domain\AllowOriginStrategy;

use JDesrosiers\Silex\Provider\Domain\AllowOriginStrategy;

class ExactHostStrategy implements AllowOriginStrategy
{
    private $allowedHosts;

    public function __construct(array $allowedHosts)
    {
        $this->allowedHosts = $allowedHosts;
    }

    /**
     * @param string $origin
     * @return bool
     */
    public function isOriginAllowed($origin)
    {
        foreach ($this->allowedHosts as $allowedHost) {
            if ($origin === $allowedHost) {
                return true;
            }
        }

        return false;
    }
}
