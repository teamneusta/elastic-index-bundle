<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Tests\Index\Repository;

use Elastica\Exception\NotFoundException;
use Elastica\ResultSet;
use JoliCode\Elastically\Client;
use JoliCode\Elastically\Index;
use JoliCode\Elastically\Indexer;
use Neusta\ElasticIndexBundle\Index\Repository\ElasticallyRepository;
use Neusta\ElasticIndexBundle\Index\Repository\Exception\CouldNotFindElasticDocument;
use Neusta\ElasticIndexBundle\Tests\Fixture\TestPageDocument;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

class ElasticallyRepositoryTest extends TestCase
{
    use ProphecyTrait;

    private ElasticallyRepository $elasticallyRepository;

    private ObjectProphecy|Index $index;
    private ObjectProphecy|Indexer $indexer;

    protected function setUp(): void
    {
        $elasticallyClient = $this->prophesize(Client::class);

        $this->elasticallyRepository = new ElasticallyRepository('cars', $elasticallyClient->reveal());

        $this->index = $this->prophesize(Index::class);
        $elasticallyClient->getIndex('cars')->willReturn($this->index);

        $this->indexer = $this->prophesize(Indexer::class);
        $elasticallyClient->getIndexer()->willReturn($this->indexer);
    }

    /** @test */
    public function find_must_search_on_index(): void
    {
        $this->index->search('formel1')
            ->shouldBeCalled()
            ->willReturn($this->prophesize(ResultSet::class));

        $this->elasticallyRepository->find('formel1');
    }

    /** @test */
    public function get_must_return_ElasticDocument(): void
    {
        $this->index->getModel('42')
            ->shouldBeCalled()
            ->willReturn(new TestPageDocument());

        $this->elasticallyRepository->get('42');
    }

    /** @test */
    public function get_must_throw_when_no_elastic_document_could_not_be_found(): void
    {
        $this->expectException(CouldNotFindElasticDocument::class);
        $this->expectExceptionMessage('Document with id "42" was not found in index "cars".');

        $this->index->getModel('42')
            ->shouldBeCalled()
            ->willThrow(new NotFoundException());

        $this->elasticallyRepository->get('42');
    }

    /** @test */
    public function add_must_create_index_for_document(): void
    {
        $testPageDocument = new TestPageDocument();
        $this->indexer->scheduleIndex('cars', new \Elastica\Document('42', $testPageDocument))
            ->shouldBeCalled();

        $this->elasticallyRepository->add('42', $testPageDocument);
    }

    /** @test */
    public function delete_must_remove_index(): void
    {
        $this->index->deleteById('42')
            ->shouldBeCalled();

        $this->elasticallyRepository->delete('42');
    }

    /** @test */
    public function delete_must_throw_when_elastic_document_could_not_be_found(): void
    {
        $this->expectException(CouldNotFindElasticDocument::class);
        $this->expectExceptionMessage('Document with id "42" was not found in index "cars".');

        $this->index->deleteById('42')
            ->shouldBeCalled()
            ->willThrow(new NotFoundException());

        $this->elasticallyRepository->delete('42');
    }

    /** @test */
    public function commit_must_be_delegated_to_indexer(): void
    {
        $this->indexer->flush()
            ->shouldBeCalled();

        $this->elasticallyRepository->commit();
    }
}
