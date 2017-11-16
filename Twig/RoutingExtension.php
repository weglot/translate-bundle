<?php
/**
 * @author Floran Pagliai
 * Date: 16/11/2017
 * Time: 09:45
 */

namespace Weglot\TranslateBundle\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RoutingExtension extends \Symfony\Bridge\Twig\Extension\RoutingExtension
{
    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * RoutingExtension constructor.
     * @param UrlGeneratorInterface $generator
     * @param string $defaultLocale
     */
    public function __construct(UrlGeneratorInterface $generator, $defaultLocale)
    {
        parent::__construct($generator);
        $this->defaultLocale = $defaultLocale;
    }


    /**
     * @param string $name
     * @param array $parameters
     * @param bool $relative
     *
     * @return string
     */
    public function getPath($name, $parameters = array(), $relative = false)
    {
        $url = parent::getPath($name, $parameters, $relative);

        return preg_replace('/\/' . $this->defaultLocale . '/', '/', $url, 1);
    }

    /**
     * @param string $name
     * @param array $parameters
     * @param bool $schemeRelative
     *
     * @return string
     */
    public function getUrl($name, $parameters = array(), $schemeRelative = false)
    {
        $url = parent::getUrl($name, $parameters, $schemeRelative);

        return preg_replace('/\/' . $this->defaultLocale . '/', '/', $url, 1);
    }
}