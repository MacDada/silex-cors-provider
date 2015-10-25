<?php

namespace Domain\AllowOriginStrategy;

use JDesrosiers\Silex\Provider\Domain\AllowOriginStrategy;

class SimpleDomainStrategy implements AllowOriginStrategy
{
    /**
     * @var array
     */
    private $allowedDomains;

    public function __construct(array $allowedDomains)
    {
        foreach ($allowedDomains as $domain) {
            $this->addAllowedDomain($domain);
        }
    }

    /**
     * @param string $domain
     */
    public function addAllowedDomain($domain)
    {
        if (2 !== count(explode('.', $domain))) {
            throw new \InvalidArgumentException('This must be a simple domain');
        }

        $this->allowedDomains[] = $domain;
    }

    /**
     * @param string $origin
     * @return bool
     */
    public function isOriginAllowed($origin)
    {
        $originDomain = $this->parseUrlDomain($origin);

        if (false === $originDomain) {
            return false;
        }

        return in_array($originDomain, $this->allowedDomains);
    }

    /**
     * @param string $url
     * @return string|false
     */
    private function parseUrlDomain($url)
    {
        $host = parse_url($url, PHP_URL_HOST);

        if (false === $host) {
            return false;
        }

        $hostNames = explode('.', $host);

        // last 2 components ("example.com" from "m.example.com")
        return $hostNames[count($hostNames) - 2].'.'.$hostNames[count($hostNames) - 1];
    }
}
