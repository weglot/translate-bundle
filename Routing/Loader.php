<?php

namespace Weglot\TranslateBundle\Routing;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class Loader
 * @package Weglot\TranslateBundle\Routing
 */
class Loader implements LoaderInterface
{
    /**
     * @var LoaderInterface
     */
    private $loader;
    /**
     * @var string[]
     */
    private $locales;
    /**
     * @var string
     */
    private $defaultLocale;


    public function __construct(LoaderInterface $loader, array $locales = [], $defaultLocale)
    {
        $this->loader = $loader;
        $this->locales = $locales;
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * {@inheritdoc}
     * We modify all the routes to add the _locale parameters and and values it can take
     * Trick du _S vu sur https://github.com/symfony/symfony/issues/9981 pour ne pas avoir la locale en langue originale dans l'URL.
     */
    public function load($resource, $type = null)
    {
        $routes = $this->loader->load($resource, $type);
        if (!$routes instanceof RouteCollection) {
            return $routes;
        }

        $excludedUrl = ['_wdt', '_profiler']; //@TODO: to move as a parameter

        foreach ($routes as $name => $route) {
            if ($route instanceof Route) {
                if ($route->getOption('translate') !== false && !$this->contains($route->getPath(), $excludedUrl)) {
                    // If we already have _locale in the URL we don't add it in the URL
                    if (strpos($route->getPath(), '{_locale}') === false) {
                        $this->addLocaleToUrl($route);
                    } else {
                        // If locale is already in the URL; we still need to add the new languages to the requirements
                        $this->addLanguagesToRequirements($route);
                    }
                }
            }
        }
        return $routes;
    }

    /**
     * @param Route $route
     */
    protected function addLocaleToUrl(Route $route)
    {
        $route
            ->setPath('/{_locale}{_S}' . ltrim($route->getPath(), '/'))
            ->addDefaults(['_locale' => $this->defaultLocale, '_S' => '/'])
            ->addRequirements([
                '_locale' => '|' . implode('|', array_map(function ($locale) {
                    return $locale === $this->defaultLocale ? '' : $locale;
                }, $this->locales)),
                '_S' => '/?'
            ]);
    }

    /**
     * @param Route $route
     */
    protected function addLanguagesToRequirements(Route $route)
    {
        $alreadyConfiguredLanguages = explode('|', $route->getRequirement('_locale'));
        $allLanguages = array_unique(
            array_merge($alreadyConfiguredLanguages, $this->locales),
            SORT_REGULAR
        );
        $route->addRequirements([
            '_locale' => '|' . implode('|', array_map(function ($locale) {
                return $locale === $this->defaultLocale ? '' : $locale;
            }, $allLanguages))
        ]);
    }

    protected function contains($str, array $arr)
    {
        foreach ($arr as $a) {
            if (stripos($str, $a) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return $this->loader->supports($resource, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function getResolver()
    {
        return $this->loader->getResolver();
    }

    /**
     * {@inheritdoc}
     */
    public function setResolver(LoaderResolverInterface $resolver)
    {
        return $this->loader->setResolver($resolver);
    }
}
