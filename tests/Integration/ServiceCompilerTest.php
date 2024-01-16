<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ServiceCompilerTest extends KernelTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        static::$kernel = static::createKernel();
    }

    /** @test */
    public function symfony_service_definitions_must_compile(): void
    {
        // when this test passed, it means that the kernel could be loaded and there are no compiling errors in the
        // symfony service definitions.
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function index_create_command_must_run_without_errors(): void
    {
        // This will mainly test the service configuration of a command
        static::$kernel->boot();
        $application = new Application(static::$kernel);

        $command = $application->find('neusta:elastic:index:create');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();
    }
}
