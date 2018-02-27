<?php
/**
 * @author Floran Pagliai
 * Date: 13/11/2017
 * Time: 14:29
 */

namespace Weglot\TranslateBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Weglot\TranslateBundle\Services\Client;
use Weglot\TranslateBundle\Services\Parser;

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

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}