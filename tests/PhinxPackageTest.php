<?php
namespace Tests\ObjectivePHP\Package\Phinx;

use ObjectivePHP\Application\AbstractApplication;
use ObjectivePHP\Cli\Router\CliRouter;
use ObjectivePHP\Package\Phinx\Command\Phinx;
use ObjectivePHP\Package\Phinx\Exception\PhinxException;
use ObjectivePHP\Package\Phinx\PhinxPackage;
use ObjectivePHP\ServicesFactory\ServicesFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class PhinxPackageTest
 *
 * @package Tests\ObjectivePHP\Package\Phinx
 */
class PhinxPackageTest extends TestCase
{
    /**
     * @test
     */
    public function isCallable()
    {
        $package = new PhinxPackage();

        $this->assertTrue(is_callable($package));
    }

    /**
     * @test
     */
    public function cliRouterServiceSetter()
    {
        $package = new PhinxPackage();

        $results = $package->setCliRouterService('fake-service');

        $this->assertAttributeEquals('fake-service', 'cliRouterService', $package);
        $this->assertEquals($results, $package);
    }

    /**
     * @test
     */
    public function invokeWhenRouterIsDefined()
    {
        $package = new PhinxPackage();

        $cliRouterMock = $this->getMockBuilder(CliRouter::class)->setMethods(['registerCommand'])->getMock();
        $cliRouterMock
            ->expects($this->once())
            ->method('registerCommand')
            ->with(new Phinx())
            ->willReturn($cliRouterMock);

        $servicesFactoryMock = $this->getMockBuilder(ServicesFactory::class)->setMethods(['get'])->getMock();
        $servicesFactoryMock->expects($this->once())->method('get')->with('cli.router')->willReturn($cliRouterMock);

        $applicationMock = $this->getMockBuilder(AbstractApplication::class)
            ->setMethods(['getServicesFactory'])
            ->getMockForAbstractClass();

        $applicationMock->expects($this->once())->method('getServicesFactory')->willReturn($servicesFactoryMock);

        /** @var AbstractApplication $applicationMock */
        $package($applicationMock);
    }

    /**
     * @test
     */
    public function invokeWhenRouterIsNotDefined()
    {
        $package = new PhinxPackage();

        $servicesFactoryMock = $this->getMockBuilder(ServicesFactory::class)->setMethods(['get'])->getMock();
        $servicesFactoryMock->expects($this->once())->method('get')->with('cli.router')->willReturn(false);

        $applicationMock = $this->getMockBuilder(AbstractApplication::class)
            ->setMethods(['getServicesFactory'])
            ->getMockForAbstractClass();

        $applicationMock->expects($this->once())->method('getServicesFactory')->willReturn($servicesFactoryMock);

        $this->expectException(PhinxException::class);
        $this->expectExceptionMessage(sprintf(
            'Cannot find %s in ServicesFactory as "%s"',
            CliRouter::class,
            'cli.router'
        ));

        /** @var AbstractApplication $applicationMock */
        $package($applicationMock);
    }
}
