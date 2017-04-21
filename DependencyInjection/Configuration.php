<?php

declare(strict_types=1);

namespace TEAEbook\Bundle\CrontabBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('crontab');

        $this->addGeneralConfig($rootNode);
        $this->addJobsConfig($rootNode);

        return $treeBuilder;
    }

    private function addGeneralConfig(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->scalarNode('working_directory')->defaultValue('')->end()
            ->end()
        ;

        return $rootNode;
    }

    private function addJobsConfig(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->fixXmlConfig('job')
            ->children()
                ->arrayNode('jobs')
                    ->prototype('array')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('command')
                                ->info('The command to execute')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('periodicity')
                                ->info('The periodicity at which the command will be executed')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('description')
                                ->info('Job description (will be included in the crontab)')
                                ->defaultNull()
                            ->end()
                            ->booleanNode('enabled')
                                ->info('If true, the job will be included in the crontab but as a commented line')
                                ->defaultTrue()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $rootNode;
    }
}
