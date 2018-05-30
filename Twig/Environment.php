<?php

namespace Weglot\TranslateBundle\Twig;

use Twig_Environment;
use Twig_LoaderInterface;

/**
 * Class Environment
 * @package Weglot\TranslateBundle\Twig
 */
class Environment extends Twig_Environment
{
    /**
     * @var array
     */
    protected $matrix;


    /**
     * @var null|string
     */
    protected $currentMatrix;

    /**
     * Environment constructor.
     * @param Twig_LoaderInterface $loader
     * @param array $options
     * @param string $originalLanguage
     * @param array $destinationLanguages
     */
    public function __construct(Twig_LoaderInterface $loader, array $options = [], $originalLanguage = 'en', array $destinationLanguages = [])
    {
        parent::__construct($loader, $options);

        $this->currentMatrix = $originalLanguage;
        $this->matrix = [
            $originalLanguage => [
                'origin' => $originalLanguage,
                'current' => $originalLanguage
            ]
        ];
        foreach ($destinationLanguages as $language) {
            $this->matrix[$language] = [
                'origin' => $originalLanguage,
                'current' => $language
            ];
        }
    }

    /**
     * @return array
     */
    public function getMatrix()
    {
        return $this->matrix[$this->currentMatrix];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function setMatrix($name)
    {
        if (isset($this->matrix[$name]) && $this->currentMatrix !== $name) {
            $this->currentMatrix = $name;
            return true;
        }
        return false;
    }
}
