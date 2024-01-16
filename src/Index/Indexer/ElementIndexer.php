<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Indexer;

/**
 * @template T of object
 */
interface ElementIndexer
{
    /**
     * @param T $element
     */
    public function save(object $element): void;

    /**
     * @param T $element
     */
    public function delete(object $element): void;

    /**
     * @param T $element
     */
    public function deleteForRegistryKey(object $element, string $registryKey): void;

    public function commit(): void;
}
