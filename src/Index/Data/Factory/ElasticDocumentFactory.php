<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Data\Factory;

use Neusta\ConverterBundle\Converter\Context\GenericContext;
use Neusta\ConverterBundle\TargetFactory;
use Neusta\ElasticIndexBundle\Index\Document\ElasticDocument;

/**
 * @extends TargetFactory<ElasticDocument, GenericContext>
 */
interface ElasticDocumentFactory extends TargetFactory
{
    public function create(object $ctx = null): ElasticDocument;
}
