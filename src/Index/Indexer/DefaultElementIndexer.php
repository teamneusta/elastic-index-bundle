<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Indexer;

use Neusta\ConverterBundle\Converter;
use Neusta\ConverterBundle\Converter\Context\GenericContext;
use Neusta\ElasticIndexBundle\Index\Data\Provider\IdentityProvider;
use Neusta\ElasticIndexBundle\Index\Document\ElasticDocument;
use Neusta\ElasticIndexBundle\Index\Registry\Exception\UnknownRegistryKey;
use Neusta\ElasticIndexBundle\Index\Registry\Registry;
use Neusta\ElasticIndexBundle\Index\Registry\RegistryKeysProvider;
use Neusta\ElasticIndexBundle\Index\Repository\ElasticRepository;

/**
 * @template T of object
 *
 * @implements ElementIndexer<T>
 */
class DefaultElementIndexer implements ElementIndexer
{
    /** @var ElasticRepository[] */
    private array $touchedRepositories = [];

    /**
     * @param Registry<Converter<T, ElasticDocument, GenericContext>> $converterRegistry
     * @param Registry<ElasticRepository>                             $repositoryRegistry
     */
    public function __construct(
        private IdentityProvider $identityProvider,
        private Registry $converterRegistry,
        private Registry $repositoryRegistry,
        private RegistryKeysProvider $keyProvider,
    ) {
    }

    /**
     * @param T $element
     *                   The save method writes $element to the index but do not remove it (anymore)
     */
    public function save(object $element): void
    {
        $registryKeys = $this->keyProvider->provide($element);
        $elementId = $this->identityProvider->identify($element);

        if (empty($registryKeys)) {
            throw new UnknownRegistryKey(
                sprintf(
                    'No registry key found for element %s',
                    $elementId
                )
            );
        }

        array_walk(
            $registryKeys,
            function ($registryKey) use ($element, $elementId) {
                $repository = $this->getRepository($registryKey);
                /** @var Converter<T, ElasticDocument, GenericContext> $converter */
                $converter = $this->getConverter($registryKey);

                $repository->add(
                    $elementId,
                    $converter->convert($element)
                );
            },
        );
    }

    /**
     * @param T $element
     */
    public function delete(object $element): void
    {
        $registryKeys = $this->keyProvider->provide($element);
        $elementId = $this->identityProvider->identify($element);

        if (empty($registryKeys)) {
            throw new UnknownRegistryKey(
                sprintf(
                    'No registry key found for element %s',
                    $elementId
                )
            );
        }

        array_walk(
            $registryKeys,
            function ($registryKey) use ($elementId) {
                $repository = $this->getRepository($registryKey);
                $repository->delete($elementId);
            },
        );
    }

    /**
     * @param T $element
     */
    public function deleteForRegistryKey(object $element, string $registryKey): void
    {
        $elementId = $this->identityProvider->identify($element);

        $repository = $this->getRepository($registryKey);
        $repository->delete($elementId);
    }

    public function commit(): void
    {
        foreach ($this->touchedRepositories as $repository) {
            $repository->commit();
        }
    }

    private function getRepository(string $objectRegistryKey): ElasticRepository
    {
        $repository = $this->repositoryRegistry->get($objectRegistryKey);

        $this->touchedRepositories[$objectRegistryKey] = $repository;

        return $repository;
    }

    private function getConverter(string $objectRegistryKey): Converter
    {
        return $this->converterRegistry->get($objectRegistryKey);
    }
}
