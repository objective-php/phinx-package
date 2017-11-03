<?php
namespace ObjectivePHP\Package\Phinx;

use ObjectivePHP\Application\ApplicationInterface;
use ObjectivePHP\Cli\Router\CliRouter;
use ObjectivePHP\Package\Phinx\Command\Phinx;
use ObjectivePHP\Package\Phinx\Exception\PhinxException;

/**
 * Class PhinxPackage
 *
 * @package ObjectivePHP\Package\Phinx
 */
class PhinxPackage
{
    protected $cliRouterService = 'cli.router';

    /**
     * @param ApplicationInterface $application
     *
     * @throws PhinxException
     */
    public function __invoke(ApplicationInterface $application)
    {
        /** @var CliRouter $router */
        $router = $application->getServicesFactory()->get($this->cliRouterService);

        if ($router) {
            $router->registerCommand(new Phinx());
        } else {
            throw new PhinxException(sprintf(
                'Cannot find %s in ServicesFactory as "%s"',
                CliRouter::class,
                $this->cliRouterService
            ));
        }
    }

    /**
     * Set CliRouterService
     *
     * @param string $cliRouterService
     *
     * @return PhinxPackage
     */
    public function setCliRouterService(string $cliRouterService): PhinxPackage
    {
        $this->cliRouterService = $cliRouterService;

        return $this;
    }
}
