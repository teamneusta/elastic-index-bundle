<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Registry;

use Neusta\ElasticIndexBundle\Index\Registry\Exception\UnknownRegistryKey;

/**
 * @template T of object
 *
 * @implements Registry<T>
 */
class ObjectRegistry implements Registry
{
    private string $name;
    /** @var array<string, T> */
    private array $registeredObjects = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param T $object
     */
    public function register(string $key, object $object): void
    {
        $this->registeredObjects[$key] = $object;
    }

    public function has(string $key): bool
    {
        return isset($this->registeredObjects[$key]);
    }

    public function get(string $key): object
    {
        if ($this->has($key)) {
            return $this->registeredObjects[$key];
        }

        throw UnknownRegistryKey::forKeyInRegistry($key, $this->name);
    }
}
