<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Data\Filter;

use Neusta\ElasticIndexBundle\Index\Data\DataCollection;

/**
 * @template T of object
 */
interface DataFilter
{
    /**
     * Return the elements, that have not been filtered.
     *
     * @param DataCollection<T> $elements
     *
     * @return DataCollection<T>
     */
    public function filter(DataCollection $elements): iterable;

    /**
     * Return the $element, when it was not filtered; else return null.
     *
     * @param T $element
     *
     * @return T|null
     */
    public function filterOne(object $element): ?object;
}
