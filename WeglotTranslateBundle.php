<?php

namespace Weglot\TranslateBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Weglot\TranslateBundle\DependencyInjection\Compiler\RouterCompilerPass;
use Weglot\TranslateBundle\DependencyInjection\Compiler\TwigCompilerPass;

/**
 * Class WeglotTranslateBundle
 * @package Weglot\TranslateBundle
 */
class WeglotTranslateBundle extends Bundle
{
    /**
     * Integration version
     *
     * @var string
     */
    const VERSION = '0.6.11';

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RouterCompilerPass());
        $container->addCompilerPass(new TwigCompilerPass());
    }
}
