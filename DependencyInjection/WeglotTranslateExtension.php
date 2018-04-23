<?php

namespace Weglot\TranslateBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class WeglotTranslateExtension
 * @package Weglot\TranslateBundle\DependencyInjection
 */
class WeglotTranslateExtension extends Extension
{

    /**
     * Loads a specific configuration.
     *
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('weglot.api_key', $config['api_key']);
        $container->setParameter('weglot.exclude_blocks', $config['exclude_blocks']);
        $container->setParameter('weglot.original_language', $config['original_language']);
        $container->setParameter('weglot.destination_languages', $config['destination_languages']);

        // manually load client to check if we using SF2 or later
        $clientService = $container
            ->register('weglot_translate.library.client', Client::class)
            ->addArgument('%weglot.api_key%');
        if ($config['cache'] &&
            ($this->stringStartWith(Kernel::VERSION, '3.') || $this->stringStartWith(Kernel::VERSION, '4.'))) {
            $clientService->addMethodCall('setCacheItemPool', [new Reference('cache.app')]);
        }

        // then load all other dependencies
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
