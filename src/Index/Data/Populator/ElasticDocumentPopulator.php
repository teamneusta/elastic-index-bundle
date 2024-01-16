<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Data\Populator;

use Neusta\ConverterBundle\Converter\Context\GenericContext;
use Neusta\ConverterBundle\Populator;
use Neusta\ElasticIndexBundle\Index\Document\ElasticDocument;

/**
 * @template T of object
 *
 * @extends Populator<ElasticDocument, T, GenericContext>
 */
interface ElasticDocumentPopulator extends Populator
{
    public function populate(object $target, object $source, object $ctx = null): void;
}
