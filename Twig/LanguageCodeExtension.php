<?php
/**
 * @author Floran Pagliai
 * Date: 07/07/2017
 * Time: 14:14
 */

namespace Weglot\TranslateBundle\Twig;

use Weglot\Client\Api\LanguageCollection;
use Weglot\Client\Endpoint\Languages;

class LanguageCodeExtension extends \Twig_Extension
{
    /**
     * @var LanguageCollection
     */
    protected $languageCollection;

    /**
     * LanguageCodeExtension constructor.
     * @param Languages $languages
     */
    public function __construct(Languages $languages)
    {
        $this->languageCollection = $languages->handle();
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('language', [$this, 'languageFilter']),
        ];
    }

    public function languageFilter($locale, $getEnglish = true)
    {
        $language = $this->languageCollection->getCode($locale);

        if ($getEnglish) {
            return $language->getEnglishName();
        }
        return $language->getLocalName();
    }
}
