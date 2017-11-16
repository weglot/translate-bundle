<?php

namespace Weglot\TranslateBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Weglot\TranslateBundle\DependencyInjection\Compiler\RouterCompilerPass;

class WeglotTranslateBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RouterCompilerPass());
    }
}
