<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ConverterRegistryPass implements CompilerPassInterface
{
    private const TAG_NAME = 'neusta.elastic_bundle.converter';
    private const REGISTRY_KEY = 'registry_key'; // @phpstan-ignore-line

    public function process(ContainerBuilder $container): void
    {
        $registryDefinition = $container->getDefinition('neusta.elastic_bundle.registry.converter');

        foreach ($container->findTaggedServiceIds(self::TAG_NAME, true) as $id => $tags) {
            foreach ($tags as [self::REGISTRY_KEY => $registryKey]) {
                $registryDefinition->addMethodCall('register', [$registryKey, new Reference($id)]);
            }
        }
    }
}
