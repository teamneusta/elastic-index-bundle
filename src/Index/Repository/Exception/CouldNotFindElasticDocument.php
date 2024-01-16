<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Repository\Exception;

final class CouldNotFindElasticDocument extends \RuntimeException
{
    public static function inIndexWithId(string $index, string $id, \Throwable $previous = null): self
    {
        return new self(sprintf('Document with id "%s" was not found in index "%s".', $id, $index), 0, $previous);
    }
}
