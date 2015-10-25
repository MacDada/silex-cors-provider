<?php

namespace Domain\AllowOriginStrategy;

use JDesrosiers\Silex\Provider\Domain\AllowOriginStrategy;

class InverseStrategy implements AllowOriginStrategy
{
    /**
     * @var AllowOriginStrategy
     */
    private $strategyToInverse;

    public function __construct(AllowOriginStrategy $strategyToInverse)
    {
        $this->strategyToInverse = $strategyToInverse;
    }

    /**
     * @param string $origin
     * @return bool
     */
    public function isOriginAllowed($origin)
    {
        return !$this->strategyToInverse->isOriginAllowed($origin);
    }
}
