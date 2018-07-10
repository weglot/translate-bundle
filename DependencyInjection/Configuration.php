<?php

namespace Weglot\TranslateBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Weglot\TranslateBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('weglot_translate');

        $rootNode
            ->children()
                ->scalarNode('api_key')->isRequired()->end()
                ->scalarNode('original_language')->isRequired()->end()
                ->arrayNode('destination_languages')->isRequired()->requiresAtLeastOneElement()
                    ->prototype('scalar')->end()->end()
                ->arrayNode('exclude_blocks')->prototype('scalar')->end()->end()
                ->booleanNode('cache')->defaultFalse()->end()
                ->scalarNode('api_host')->defaultValue('https://api.weglot.com')->end()
            ->end();

        return $treeBuilder;
    }
}
