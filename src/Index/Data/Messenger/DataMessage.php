<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Data\Messenger;

class DataMessage
{
    public function __construct(
        private int $id,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
