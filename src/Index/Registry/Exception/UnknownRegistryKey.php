<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Registry\Exception;

final class UnknownRegistryKey extends \LogicException
{
    public static function forKeyInRegistry(string $key, string $registryName): self
    {
        return new self(sprintf('Unknown key "%s" in registry "%s".', $key, $registryName));
    }
}
