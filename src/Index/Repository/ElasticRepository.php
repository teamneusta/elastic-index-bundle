<?php
declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Repository;

use Elastica\ResultSet;
use Neusta\ElasticIndexBundle\Index\Document\ElasticDocument;
use Neusta\ElasticIndexBundle\Index\Repository\Exception\CouldNotFindElasticDocument;

interface ElasticRepository
{
    public function find(string $term): ResultSet;

    /**
     * @throws CouldNotFindElasticDocument
     */
    public function get(string $id): ElasticDocument;

    public function add(string $id, ElasticDocument $document): void;

    /**
     * @throws CouldNotFindElasticDocument
     */
    public function delete(string $id): void;

    public function commit(): void;
}
