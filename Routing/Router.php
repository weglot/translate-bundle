<?php
/**
 * @author Floran Pagliai
 * Date: 16/11/2017
 * Time: 11:03
 */

namespace Weglot\TranslateBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\Router as BaseRouter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class Router extends BaseRouter
{
    /**
     * @var string
     */
    private $defaultLocale;
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param $defaultLocale string
     */
    public function setDefaultLocale($defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     */
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        $this->preGenerate($name, $parameters);
        return parent::generate($name, $parameters, $referenceType);
    }

    /**
     * {@inheritdoc}
     */
    public function match($pathinfo)
    {
        $parameters = parent::match($pathinfo);
        $this->postMatch($parameters);
        return $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function matchRequest(Request $request)
    {
        $parameters = parent::matchRequest($request);
        $this->postMatch($parameters);
        return $parameters;
    }

    private function preGenerate($name, array &$parameters = [])
    {
        if (null === $route = $this->getRouteCollection()->get($name)) {
            return;
        }
        if (false === $route->getOption('translate')) {
            return;
        }
        if (isset($parameters['_locale'])) {
            $locale = $parameters['_locale'];
        } else {
            $request = $this->requestStack->getCurrentRequest();
            $locale = $request === null ? $this->defaultLocale : $request->getLocale();
        }
        $parameters['_locale'] = $this->defaultLocale === $locale ? '' : $locale . '/';
    }

    private function postMatch(array &$parameters = [])
    {
        if (!isset($parameters['_route']) || !isset($parameters['_locale'])) {
            return;
        }
        if (null === $route = $this->getRouteCollection()->get($parameters['_route'])) {
            return;
        }
        if (false === $route->getOption('translate')) {
            return;
        }
        $parameters['_locale'] = isset($parameters['_locale']) && '' !== $parameters['_locale']
            ? rtrim($parameters['_locale'], '/')
            : $this->defaultLocale;
    }
}