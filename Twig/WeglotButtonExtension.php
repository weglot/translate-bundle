<?php
/**
 * @author Floran Pagliai
 * Date: 07/07/2017
 * Time: 14:14
 */

namespace Weglot\TranslateBundle\Twig;


use Weglot\TranslateBundle\Services\LanguageFilter;

class WeglotButtonExtension extends \Twig_Extension
{
    /**
     * Original language
     *
     * @var string
     */
    private $originalLanguage;

    /**
     *  destination_languages
     *
     * @var array
     */
    private $destinationLanguages = [];

    /**
     * WeglotButtonExtension constructor.
     * @param $originalLanguage
     * @param $destinationLanguages
     */
    public function __construct($originalLanguage, array $destinationLanguages)
    {
        $this->originalLanguage = $originalLanguage;
        $this->destinationLanguages = $destinationLanguages;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'weglot_translate_render',
                array(
                    $this,
                    'renderWeglotTranslate',
                ),
                array('needs_environment' => true, 'is_safe' => ['html'])
            ),
        );
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
            array(
                'original_language' => $this->originalLanguage,
                'destination_languages' => $this->destinationLanguages
            )
        );
    }


    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('language', array($this, 'languageFilter')),
        );
    }

    public function languageFilter($locale, $getEnglish = true)
    {
        return LanguageFilter::languageFilter($locale, $getEnglish);
    }
}