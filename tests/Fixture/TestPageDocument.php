<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Tests\Fixture;

use Neusta\ElasticIndexBundle\Index\Document\ElasticDocument;

class TestPageDocument implements ElasticDocument
{
    public string $title = 'still empty';
    public bool $switch = false;
    public ?\DateTimeImmutable $dateTime = null;
    public ?int $testId = null;
    public array $list = [];
}
