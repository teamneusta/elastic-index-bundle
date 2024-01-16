<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Data\Filter;

use Neusta\ElasticIndexBundle\Index\Data\DataCollection;

/**
 * @template T of object
 *
 * @implements DataFilter<T>
 */
abstract class AbstractDataFilter implements DataFilter
{
    /**
     * @param DataCollection<T> $elements
     */
    final public function filter(DataCollection $elements): iterable
    {
        foreach ($elements as $element) {
            if (null !== $this->filterOne($element)) {
                yield $element;
            }
        }
    }

    /**
     * @param T $element
     *
     * @return T|null
     */
    abstract public function filterOne(object $element): ?object;
}
