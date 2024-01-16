<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Data\Filter;

final class NoOperationFilter extends AbstractDataFilter
{
    public function filterOne(object $element): ?object
    {
        return $element;
    }
}
