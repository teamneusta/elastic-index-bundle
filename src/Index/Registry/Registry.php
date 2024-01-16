<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Registry;

use Neusta\ElasticIndexBundle\Index\Registry\Exception\UnknownRegistryKey;

/**
 * @template T of object
 */
interface Registry
{
    public function has(string $key): bool;

    /**
     * @return T
     *
     * @throws UnknownRegistryKey
     */
    public function get(string $key): object;
}
