<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Registry;

use Neusta\ElasticIndexBundle\Index\Registry\Exception\CouldNotProvideRegistryKey;

/**
 * @template T of object
 */
interface RegistryKeysProvider
{
    public function canProvide(object $object): bool;

    /**
     * @return array<string>
     *
     * @throws CouldNotProvideRegistryKey
     */
    public function provide(object $object): array;
}
