<?php

namespace Weglot\TranslateBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class RouterCompilerPass
 * @package Weglot\TranslateBundle\DependencyInjection\Compiler
 */
class RouterCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $container->setAlias('router', 'weglot_translate.routing.router');
    }
}
