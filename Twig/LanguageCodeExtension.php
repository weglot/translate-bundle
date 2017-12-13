<?php
/**
 * @author Floran Pagliai
 * Date: 07/07/2017
 * Time: 14:14
 */

namespace Weglot\TranslateBundle\Twig;


use Weglot\TranslateBundle\Services\LanguageFilter;

class LanguageCodeExtension extends \Twig_Extension
{
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