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

        $container->setDefinition('weglot_translate.client', new Definition(
            Client::class, array(
                $config['api_key']
            )
        ));

        $container->setDefinition('weglot_translate.parser', new Definition(
            Parser::class, array(
                $container->findDefinition('weglot_translate.client'),
                $config['exclude_blocks']
            )
        ));
        $container->setParameter('weglot.locales_requirement', '|' . $container->getParameter('kernel.default_locale') . '|' . implode('|', $config['destination_languages']));

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}