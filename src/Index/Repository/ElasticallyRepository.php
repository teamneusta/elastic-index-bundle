<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Repository;

use Elastica\Exception\NotFoundException;
use Elastica\ResultSet;
use JoliCode\Elastically\Client;
use JoliCode\Elastically\Index;
use JoliCode\Elastically\Indexer;
use Neusta\ElasticIndexBundle\Index\Document\ElasticDocument;
use Neusta\ElasticIndexBundle\Index\Repository\Exception\CouldNotFindElasticDocument;

final class ElasticallyRepository implements ElasticRepository
{
    private string $indexName;
    private Client $client;

    public function __construct(string $indexName, Client $client)
    {
        $this->indexName = $indexName;
        $this->client = $client;
    }

    public function find(string $term): ResultSet
    {
        return $this->getIndex()->search($term);
    }

    public function get(string $id): ElasticDocument
    {
        try {
            return $this->getIndex()->getModel($id);
        } catch (NotFoundException $e) {
            throw CouldNotFindElasticDocument::inIndexWithId($this->indexName, $id, $e);
        }
    }

    public function add(string $id, ElasticDocument $document): void
    {
        $this->getIndexer()->scheduleIndex($this->indexName, new \Elastica\Document($id, $document)); // @phpstan-ignore-line
    }

    public function delete(string $id): void
    {
        try {
            $this->getIndex()->deleteById($id);
        } catch (NotFoundException $e) {
            throw CouldNotFindElasticDocument::inIndexWithId($this->indexName, $id, $e);
        }
    }

    public function commit(): void
    {
        $this->getIndexer()->flush();
    }

    private function getIndexer(): Indexer
    {
        return $this->client->getIndexer();
    }

    private function getIndex(): Index
    {
        return $this->client->getIndex($this->indexName);
    }
}
