<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Tests\Fixture\Messenger;

use Neusta\ElasticIndexBundle\Index\Data\Messenger\DataMessage;
use Neusta\ElasticIndexBundle\Index\Data\Messenger\DataMessageFactory;

class TestDataMessageFactory implements DataMessageFactory
{
    public function create(object $object): DataMessage
    {
        return new DataMessage($object);
    }
}
