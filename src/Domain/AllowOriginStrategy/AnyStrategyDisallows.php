<?php

namespace Domain\AllowOriginStrategy;

use JDesrosiers\Silex\Provider\Domain\AllowOriginStrategy;

class AnyStrategyDisallows implements AllowOriginStrategy
{
    /**
     * @var AllowOriginStrategy[]
     */
    private $strategies;

    /**
     * @param AllowOriginStrategy[] $strategies
     */
    public function __construct(array $strategies)
    {
        foreach ($strategies as $strategy)
        {
            $this->strategies[] = $strategy;
        }
    }

    public function addStrategy(AllowOriginStrategy $strategy)
    {
        $this->strategies[] = $strategy;
    }

    /**
     * @param string $origin
     * @return bool
     */
    public function isOriginAllowed($origin)
    {
        foreach ($this->strategies as $strategy)
        {
            if ($strategy->isOriginAllowed($origin)) {
                return false;
            }
        }

        return true;
    }
}
