<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class NeustaElasticIndexExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void  // @phpstan-ignore-line
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(\dirname(__DIR__, 2) . '/config'));
        $loader->load('services.yaml');
    }
}
