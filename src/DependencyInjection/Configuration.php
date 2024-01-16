<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\DependencyInjection;

use Neusta\ElasticIndexBundle\Index\Data\Filter\NoOperationFilter;
use Neusta\ElasticIndexBundle\Pimcore\Index\DataObjectRepository;
use Neusta\ElasticIndexBundle\Pimcore\Index\PageRepository;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('neusta_elastic');
        $root = $treeBuilder->getRootNode();

        $root
            ->children()
                ->arrayNode('hosts')
                    ->scalarPrototype()->end()
                    ->defaultValue(['elasticsearch:9200'])
                ->end()
                ->arrayNode('commands')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('data_object')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('enable_default_handler')->defaultTrue()->end()
                                ->scalarNode('repository')
                                    ->info('Service id of the "DataObjectRepository" that is used in the neusta:elastic:index:objects command.')
                                    ->defaultValue(DataObjectRepository::class)
                                ->end()
                                ->scalarNode('filter')
                                    ->info('Service id of the "DataObjectFilter" that is used in the neusta:elastic:index:objects command.')
                                    ->defaultValue(NoOperationFilter::class)
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('page')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('enable_default_handler')->defaultTrue()->end()
                                ->scalarNode('repository')
                                    ->info('Service id of the "PageRepository" that is used in the neusta:elastic:index:pages command.')
                                    ->defaultValue(PageRepository::class)
                                ->end()
                                ->scalarNode('filter')
                                    ->info('Service id of the "PageFilter" that is used in the neusta:elastic:index:pages command.')
                                    ->defaultValue(NoOperationFilter::class)
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
