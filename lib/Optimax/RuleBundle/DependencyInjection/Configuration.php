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
                ->scalarNode('dir_name')->defaultValue('%kernel.root_dir%/RuleActions')->cannotBeEmpty()->end()
                ->scalarNode('namespace')->defaultValue('OptimaxRuleAction')->cannotBeEmpty()->end()
            ->end();

        return $treeBuilder;
    }
}
