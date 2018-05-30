<?php

namespace Weglot\TranslateBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Weglot\TranslateBundle\Twig\Environment;

/**
 * Class TwigCompilerPass
 * @package Weglot\TranslateBundle\DependencyInjection\Compiler
 */
class TwigCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $twigDefinition = $container->getDefinition('twig');

        // replace Twig_Environment class
        $twigDefinition->setClass(Environment::class);

        // set original & destination languages
        $twigDefinition->setArgument(2, '%weglot.original_language%');
        $twigDefinition->setArgument(3, '%weglot.destination_languages%');
    }
}
