<?php declare(strict_types=1);

use Neusta\ElasticIndexBundle\NeustaElasticIndexBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        yield new FrameworkBundle();
        yield new NeustaElasticIndexBundle();
    }

    public function getProjectDir(): string
    {
        return __DIR__;
    }
}
