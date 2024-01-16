<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Data\Messenger;

/**
 * @template T of object
 */
interface DataMessageFactory
{
    /**
     * @param T $object
     */
    public function create(object $object): DataMessage;
}
