<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\DependencyInjection;

use Neusta\ElasticIndexBundle\Pimcore\Index\Command\IndexDataObjectsCommand;
use Neusta\ElasticIndexBundle\Pimcore\Index\Command\IndexPagesCommand;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

final class NeustaElasticExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void  // @phpstan-ignore-line
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(\dirname(__DIR__, 2) . '/config'));
        $loader->load('services.yaml');

        $container->setParameter('neusta_elastic.elasticsearch_hosts', $mergedConfig['hosts']);

        // 'commands.data_object' config
        if (true === $mergedConfig['commands']['data_object']['enable_default_handler']) {
            $loader->load('services/pimcore/default_handler_data_object.yaml');
        }
        $serviceIdRepository = $mergedConfig['commands']['data_object']['repository'];
        $serviceIdFilter = $mergedConfig['commands']['data_object']['filter'];
        $indexDataObjectsCommand = $container->getDefinition(IndexDataObjectsCommand::class);
        $indexDataObjectsCommand->setArgument('$repository', new Reference($serviceIdRepository));
        $indexDataObjectsCommand->setArgument('$filter', new Reference($serviceIdFilter));

        // 'commands.page' config
        if (true === $mergedConfig['commands']['page']['enable_default_handler']) {
            $loader->load('services/pimcore/default_handler_page.yaml');
        }
        $serviceIdRepository = $mergedConfig['commands']['page']['repository'];
        $serviceIdFilter = $mergedConfig['commands']['page']['filter'];
        $indexPagesCommand = $container->getDefinition(IndexPagesCommand::class);
        $indexPagesCommand->setArgument('$repository', new Reference($serviceIdRepository));
        $indexPagesCommand->setArgument('$filter', new Reference($serviceIdFilter));
    }
}
