<?php
/**
 * @author Floran Pagliai
 * Date: 16/11/2017
 * Time: 10:58
 */

namespace Weglot\TranslateBundle\Routing;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

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
     */
    public function load($resource, $type = null)
    {
        $routes = $this->loader->load($resource, $type);
        if (!$routes instanceof RouteCollection) {
            return $routes;
        }
        foreach ($routes as $name => $route) {
            if ($route instanceof Route) {
                if ($route->getOption('translate') !== false) {
                    $route
                        ->setPath('/{_locale}' . ltrim($route->getPath(), '/'))
                        ->addDefaults(['_locale' => ''])
                        ->addRequirements([
                            '_locale' => '|' . implode('|', array_map(function ($locale) {
                                    return $locale === $this->defaultLocale ? '' : $locale . '/';
                                }, $this->locales)),
                        ]);
                }
            }
        }
        return $routes;
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