<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Data;

/**
 * @template T of object
 */
interface DataRepository
{
    /**
     * @return DataCollection<T>
     */
    public function findAll(): DataCollection;
}
