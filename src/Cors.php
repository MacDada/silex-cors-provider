<?php

namespace JDesrosiers\Silex\Provider;

use JDesrosiers\Silex\Provider\Domain\AllowOriginStrategy;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    private $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    public function __invoke(Request $request, Response $response)
    {
        $response->headers->add($this->corsHeaders($request, $response->headers->get("Allow")));
    }

    private function corsHeaders(Request $request, $allow)
    {
        $headers = array();

        if (!$this->app['cors.domain']->isCorsRequest($request)) {
            return array();
        }

        if ($this->app['cors.domain']->isPreflightRequest($request)) {
            $allowedMethods = $this->allowedMethods($allow);
            $requestMethod = $request->headers->get("Access-Control-Request-Method");
            if (!in_array($requestMethod, preg_split("/\s*,\s*/", $allowedMethods))) {
                return array();
            }

            // TODO: Allow cors.allowHeaders to be set and use it to validate the request
            $headers["Access-Control-Allow-Headers"] = $request->headers->get("Access-Control-Request-Headers");
            $headers["Access-Control-Allow-Methods"] = $allowedMethods;
            $headers["Access-Control-Max-Age"] = $this->app["cors.maxAge"];
        } else {
            $headers["Access-Control-Expose-Headers"] = $this->app["cors.exposeHeaders"];
        }

        $headers["Access-Control-Allow-Origin"] = $this->allowOrigin($request);
        $headers["Access-Control-Allow-Credentials"] = $this->allowCredentials();

        return array_filter($headers);
    }

    private function allowedMethods($allow)
    {
        return !is_null($this->app["cors.allowMethods"]) ? $this->app["cors.allowMethods"] : $allow;
    }

    /**
     * @param Request $request
     * @return string
     */
    private function allowOrigin(Request $request)
    {
        $origin = $request->headers->get('Origin');

        return $this->getAllowOriginStrategy()->isOriginAllowed($origin)
            ? $origin
            : 'null';
    }

    private function allowCredentials()
    {
        return true === $this->app['cors.allowCredentials'] ? 'true' : null;
    }

    /**
     * @return Domain\AllowOriginStrategy
     * @throws \UnexpectedValueException
     */
    private function getAllowOriginStrategy()
    {
        $strategy = $this->app['cors.allow_origin_strategy'];

        if (!$this->app['cors.allow_origin_strategy'] instanceof Domain\AllowOriginStrategy) {
            throw new \UnexpectedValueException();
        }

        return $strategy;
    }
}
