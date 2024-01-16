<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Command;

use JoliCode\Elastically\Client;
use Neusta\ElasticIndexBundle\Index\Elastically\IndexesRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateIndexCommand extends Command
{
    protected static $defaultName = 'neusta:elastic:index:create';

    private Client $client;
    private IndexesRepository $indexesRepository;

    public function __construct(Client $client, IndexesRepository $indexesRepository)
    {
        parent::__construct();
        $this->client = $client;
        $this->indexesRepository = $indexesRepository;
    }

    protected function configure(): void
    {
        $this->setDescription('Create Elasticsearch indexes.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Start creating new indexes and move aliases.');

        $indexBuilder = $this->client->getIndexBuilder();

        foreach ($this->indexesRepository->getAllIndexes() as $indexName) {
            $indexBuilder->markAsLive($indexBuilder->createIndex($indexName), $indexName);
            $indexBuilder->purgeOldIndices($indexName);
        }

        $output->writeln('Creating indexes done');

        return Command::SUCCESS;
    }
}
