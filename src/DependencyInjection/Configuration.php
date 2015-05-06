<?php

namespace Paysera\Bundle\WalletBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('paysera_wallet');

        $rootNode->children()
            ->scalarNode('client_id')->isRequired()->end()
            ->scalarNode('secret')->defaultNull()->end()
            ->arrayNode('certificate')->children()
                ->scalarNode('private_key_path')->isRequired()->end()
                ->scalarNode('private_key_password')->defaultNull()->end()
                ->scalarNode('private_key_type')->defaultValue('PEM')->end()
                ->scalarNode('certificate_path')->isRequired()->end()
                ->scalarNode('certificate_password')->defaultNull()->end()
                ->scalarNode('certificate_type')->defaultValue('PEM')->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
