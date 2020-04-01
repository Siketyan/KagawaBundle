<?php

declare(strict_types=1);

namespace Siketyan\KagawaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('siketyan_kagawa');

        return $treeBuilder
            ->getRootNode()
                ->children()
                    ->scalarNode('geoip_db')
                        ->defaultNull()
                        ->info('The path to GeoIP database.')
                    ->end()
                    ->scalarNode('message')
                        ->defaultNull()
                        ->info('The hint message.')
                    ->end()
                ->end()
            ->end()
        ;
    }
}
