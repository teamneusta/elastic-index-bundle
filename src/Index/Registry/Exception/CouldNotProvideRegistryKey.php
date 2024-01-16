<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Registry\Exception;

final class CouldNotProvideRegistryKey extends \RuntimeException
{
    public static function for(object $object): self
    {
        return new self(sprintf('Cannot provide registry key for "%s".', $object::class));
    }

    public static function forPageWithController(string $controller): self
    {
        return new self(sprintf('Cannot provide registry key for Page with Controller "%s".', $controller));
    }
}
