<?php

namespace Weglot\TranslateBundle\Twig\Extensions;

use Weglot\Client\Api\LanguageCollection;
use Weglot\Client\Endpoint\Languages;

/**
 * Class Button
 * @package Weglot\TranslateBundle\Twig\Extensions
 */
class Button extends \Twig_Extension
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
     * @var LanguageCollection
     */
    protected $languageCollection;

    /**
     * WeglotButtonExtension constructor.
     * @param string $originalLanguage
     * @param array $destinationLanguages
     * @param Languages $languages
     */
    public function __construct($originalLanguage, array $destinationLanguages, Languages $languages)
    {
        $this->originalLanguage = $originalLanguage;
        $this->destinationLanguages = $destinationLanguages;

        $this->languageCollection = $languages->handle();
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'weglot_translate_render',
                [
                    $this,
                    'renderWeglotTranslate',
                ],
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'weglot_translate';
    }

    /**
     * Render weglot button.
     *
     * @param \Twig_Environment $twigEnvironment
     *
     * @return string
     */
    public function renderWeglotTranslate(\Twig_Environment $twigEnvironment, $nbtemplate)
    {
        return $twigEnvironment->render(
            '@WeglotTranslate/language-button-' . $nbtemplate . '.html.twig',
            [
                'original_language' => $this->originalLanguage,
                'destination_languages' => $this->destinationLanguages
            ]
        );
    }
}
