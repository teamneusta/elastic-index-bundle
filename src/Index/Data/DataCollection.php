<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Data;

/**
 * @template T of object
 */
interface DataCollection extends \IteratorAggregate, \Countable
{
    /**
     * @return \Traversable<int, T>
     */
    public function getIterator(): \Traversable;
}
