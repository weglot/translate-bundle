<?php
/**
 * @author Floran Pagliai
 * Date: 16/11/2017
 * Time: 11:18
 */

namespace Weglot\TranslateBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

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