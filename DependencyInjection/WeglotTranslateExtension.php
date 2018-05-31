<?php

namespace Weglot\TranslateBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Weglot\Client\Client;

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

        $this->manualServicesLoad($config, $container);

        // then load all other dependencies
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('twig.yml');
        $loader->load('console.yml');
    }

    /**
     * Manually load client (if `cache:true` in config) to check if we using SF2 or later
     * Also, we're adding custom user-agent to php library
     *
     * @param array $config
     * @param ContainerBuilder $container
     */
    protected function manualServicesLoad(array $config, ContainerBuilder $container)
    {
        $clientService = $container
            ->register('weglot_translate.library.client', Client::class)
            ->addArgument('%weglot.api_key%');

        if ($config['cache'] &&
            ($this->stringStartWith(Kernel::VERSION, '3.') || $this->stringStartWith(Kernel::VERSION, '4.'))) {
            // register cache object
            $container
                ->register('weglot_translate.cache.translations', FilesystemAdapter::class)
                ->setArguments(['weglot.translations'])
                ->setPublic(true);

            // then using it as PSR-6 cache pool
            $clientService->addMethodCall('setCacheItemPool', [new Reference('weglot_translate.cache.translations')]);
        }
    }

    /**
     * @param string $subject
     * @param string $needed
     * @return bool
     */
    private function stringStartWith($subject, $needed)
    {
        return preg_match('#^' .$needed. '#i', $subject);
    }
}
