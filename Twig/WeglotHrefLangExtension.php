<?php

namespace Weglot\TranslateBundle\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Weglot\TranslateBundle\Routing\Router;

/**
 * Class WeglotHrefLangExtension
 * @package Weglot\TranslateBundle\Twig
 */
class WeglotHrefLangExtension extends \Twig_Extension
{
    /**
     * @var string
     */
    protected $originalLanguage;

    /**
     * @var array
     */
    protected $destinationLanguages = [];

    /**
     * @var RequestStack
     */
    protected $requestStack = null;

    /**
     * @var Router
     */
    protected $router = null;

    /**
     * WeglotHrefLangExtension constructor.
     * @param $originalLanguage
     * @param array $destinationLanguages
     */
    public function __construct($originalLanguage, array $destinationLanguages, RequestStack $requestStack, Router $router)
    {
        $this->originalLanguage = $originalLanguage;
        $this->destinationLanguages = $destinationLanguages;
        $this->requestStack = $requestStack;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'weglot_hreflang_render',
                [
                    $this,
                    'renderHrefLang',
                ],
                [
                    'needs_environment' => true,
                    'is_safe' => ['html']
                ]
            ),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'weglot_hreflang';
    }

    /**
     * Render hreflang.
     *
     * @param \Twig_Environment $twigEnvironment
     * @return string
     */
    public function renderHrefLang(\Twig_Environment $twigEnvironment)
    {
        return $twigEnvironment->render(
            '@WeglotTranslate/hreflangs.html.twig',
            [
                'urls' => $this->generateUrls()
            ]
        );
    }

    /**
     * @return array
     */
    protected function generateUrls()
    {
        // get current route
        $request = $this->requestStack->getCurrentRequest();
        $route = $request->attributes->get('_route');

        // generate all possible urls
        $urls = [];

        // for original language
        $urls[$this->originalLanguage] = $this->router->generate($route, ['_locale' => $this->originalLanguage]);

        // for destination languages
        foreach ($this->destinationLanguages as $language) {
            $urls[$language] = $this->router->generate($route, ['_locale' => $language]);
        }

        return $urls;
    }
}
