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
    private $original_language;

    /**
     *  destination_languages
     *
     * @var array
     */
    private $destination_languages = [];

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
     * @param array $original
     */
    public function setOriginalLanguage($original)
    {
        $this->original_language = $original;
    }
    /**
     * @param array $destinations
     */
    public function setDestinationLanguages(array $destinations)
    {
        $this->destination_languages = $destinations;
    }


    /**
     * Render weglot button.
     *
     * @param \Twig_Environment $twigEnvironment
     *
     * @return string
     */
    public function renderWeglotTranslate(\Twig_Environment $twigEnvironment,  $nbtemplate)
    {
        $original_language = $this->original_language;
        $destination_languages = $this->destination_languages;
        return $twigEnvironment->render(
                'WeglotTranslate@language-button-'.$nbtemplate.'.html.twig',
            array( 'original_language' => $original_language , 'destination_languages' => $destination_languages )
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