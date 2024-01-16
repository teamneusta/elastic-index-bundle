<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Command;

use Neusta\ElasticIndexBundle\Index\Data\DataRepository;
use Neusta\ElasticIndexBundle\Index\Data\Filter\DataFilter;
use Neusta\ElasticIndexBundle\Index\Data\Messenger\DataMessageFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

final class IndexCommand extends Command
{
    protected static $defaultName = 'neusta:elastic:index:data';

    public function __construct(
        private DataRepository $repository,
        private DataFilter $filter,
        private DataMessageFactory $messageFactory,
        private MessageBusInterface $bus,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Re-index your data.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dataObjects = $this->repository->findAll();

        $filteredElements = $this->filter->filter($dataObjects);

        $io = new SymfonyStyle($input, $output);

        $io->title('Start indexing');
        $io->writeln([
            sprintf('Repository returns %s items.', \count($dataObjects)),
            '(The number of Elements returned from the Repository may differ from the number of actually indexed Elements due to filter constraints.)',
            '',
        ]);

        $io->section('Index counter');

        foreach ($io->progressIterate($filteredElements) as $dataObject) {
            $message = $this->messageFactory->create($dataObject);
            $this->bus->dispatch($message);
        }

        $output->writeln([
            '',
            '',
            'Done',
        ]);

        return Command::SUCCESS;
    }
}
