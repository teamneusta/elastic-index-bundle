<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Tests\Index\Elastically;

use JoliCode\Elastically\Client;
use Neusta\ElasticIndexBundle\Index\Elastically\IndexesRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

class IndexesRepositoryTest extends TestCase
{
    use ProphecyTrait;

    private IndexesRepository $indexesRepository;

    private ObjectProphecy|Client $client;

    protected function setUp(): void
    {
        $this->client = $this->prophesize(Client::class);

        $this->indexesRepository = new IndexesRepository($this->client->reveal());
    }

    /** @test */
    public function getAllClassMappings_must_return_class_mappings(): void
    {
        $classMapping = [
            'content' => 'AppBundle\Elastic\DocumentType\Content',
            'event' => 'AppBundle\Elastic\DocumentType\Event',
            'news' => 'AppBundle\Elastic\DocumentType\News',
            'press_release' => 'AppBundle\Elastic\DocumentType\PressRelease',
        ];

        $this->client->getConfig(Client::CONFIG_INDEX_CLASS_MAPPING)
            ->willReturn($classMapping);

        $actualClassMapping = $this->indexesRepository->getAllClassMappings();
        self::assertSame($classMapping, $actualClassMapping);
    }

    /** @test */
    public function getAllIndexes_must_return_keys_of_class_mapping(): void
    {
        $classMapping = [
            'content' => 'AppBundle\Elastic\DocumentType\Content',
            'event' => 'AppBundle\Elastic\DocumentType\Event',
            'news' => 'AppBundle\Elastic\DocumentType\News',
            'press_release' => 'AppBundle\Elastic\DocumentType\PressRelease',
        ];

        $expectedIndexes = ['content', 'event', 'news', 'press_release'];

        $this->client->getConfig(Client::CONFIG_INDEX_CLASS_MAPPING)
            ->willReturn($classMapping);

        $indexes = $this->indexesRepository->getAllIndexes();
        self::assertSame($expectedIndexes, $indexes);
    }
}
