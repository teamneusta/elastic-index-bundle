<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle;

use Neusta\ElasticIndexBundle\DependencyInjection\Compiler\ConverterRegistryPass;
use Neusta\ElasticIndexBundle\DependencyInjection\Compiler\RepositoryRegistryPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class NeustaElasticIndexBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new ConverterRegistryPass());
        $container->addCompilerPass(new RepositoryRegistryPass());
    }
}
