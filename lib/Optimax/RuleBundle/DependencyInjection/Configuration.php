<?php

namespace Optimax\RuleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('optimax_rules');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('namespace')->cannotBeEmpty()->end()
            ->end();

        return $treeBuilder;
    }
}
