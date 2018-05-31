<?php

namespace Weglot\TranslateBundle\Twig\Extensions;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Weglot\TranslateBundle\Routing\Router;
use Weglot\Util\Url;

/**
 * Class HrefLang
 * @package Weglot\TranslateBundle\Twig\Extensions
 */
class HrefLang extends \Twig_Extension
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
     * @param string $originalLanguage
     * @param array $destinationLanguages
     * RequestStack $requestStack
     * Router $router
     */
    public function __construct(
        $originalLanguage,
        array $destinationLanguages,
        RequestStack $requestStack,
        Router $router
    ) {
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
        $request = $this->requestStack->getCurrentRequest();
        $url = new Url($request->getUri(), $this->originalLanguage, $this->destinationLanguages);

        return $url->generateHrefLangsTags();
    }
}
