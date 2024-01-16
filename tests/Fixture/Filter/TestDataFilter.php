<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Tests\Fixture\Filter;

use Neusta\ElasticIndexBundle\Index\Data\DataCollection;
use Neusta\ElasticIndexBundle\Index\Data\Filter\DataFilter;

class TestDataFilter implements DataFilter
{
    public function filter(DataCollection $elements): iterable
    {
        return $elements;
    }

    public function filterOne(object $element): ?object
    {
        return null;
    }
}
