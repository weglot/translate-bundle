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
        $parameters = $this->preGenerate($name, $parameters);

        return parent::generate($name, $parameters, $referenceType);
    }

    /**
     * {@inheritdoc}
     */
    public function match($pathinfo)
    {
        $parameters = parent::match($pathinfo);
        return $parameters;
        //return $this->postMatch($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function matchRequest(Request $request)
    {
        $parameters = parent::matchRequest($request);
        return $parameters;
        //return $this->postMatch($parameters);
    }


    private function preGenerate($name, array $parameters = [])
    {
        $route = $this->getRouteCollection()->get($name);
        if ($route === null) {
            return $parameters;
        }
        if ($route->getOption('translate') === false) {
            return $parameters;
        }
        if (isset($parameters['_locale'])) {
            $locale = $parameters['_locale'];
        } else {
            $request = $this->requestStack->getCurrentRequest();
            $locale = $request === null ? $this->defaultLocale : $request->getLocale();
        }



        if ($route->hasDefault('_S')) {
            $parameters['_S']       = $this->defaultLocale === $locale ? '' : '/';
            $parameters['_locale']  = $this->defaultLocale === $locale ? '' : $locale;
        }


        return $parameters;
    }

    /* We don't need this anymore as we changed _locale from zh/ to zh so no need to add or remove a slash */
    private function postMatch(array $parameters = [])
    {
        if (!isset($parameters['_route']) || !isset($parameters['_locale'])) {
            return $parameters;
        }
        $route = $this->getRouteCollection()->get($parameters['_route']);
        if ($route === null) {
            return $parameters;
        }
        if ($route->getOption('translate') === false) {
            return $parameters;
        }
        $parameters['_locale'] = isset($parameters['_locale']) && '' !== $parameters['_locale']
            ? rtrim($parameters['_locale'], '/')
            : $this->defaultLocale;

        return $parameters;
    }
}