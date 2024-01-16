<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Tests\Fixture\Repository;

use Neusta\ElasticIndexBundle\Index\Data\DataCollection;
use Neusta\ElasticIndexBundle\Index\Data\DataRepository;

class TestDataRepository implements DataRepository
{

    /**
     * @inheritDoc
     */
    public function findAll(): DataCollection
    {
        // TODO: Implement findAll() method.
    }
}
