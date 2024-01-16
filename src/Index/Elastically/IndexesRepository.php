<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Elastically;

use JoliCode\Elastically\Client;

class IndexesRepository
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Should be set via yaml service config 'elastically_index_class_mapping'.
     *
     * @return array<string, string> [$className => $FQClassName]
     */
    public function getAllClassMappings(): array
    {
        $config = $this->client->getConfig(Client::CONFIG_INDEX_CLASS_MAPPING);

        return \is_array($config) ? $config : [];
    }

    /**
     * @return list<string>
     */
    public function getAllIndexes(): array
    {
        return array_keys($this->getAllClassMappings());
    }
}
