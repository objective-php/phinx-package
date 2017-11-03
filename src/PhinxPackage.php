<?php
namespace ObjectivePHP\Package\Phinx;

use ObjectivePHP\Application\ApplicationInterface;
use ObjectivePHP\Cli\Router\CliRouter;
use ObjectivePHP\Package\Phinx\Command\Phinx;

/**
 * Class PhinxPackage
 *
 * @package ObjectivePHP\Package\Phinx
 */
class PhinxPackage
{
    protected $cliRouterService = 'cli.router';
    protected $plugInStep = 'bootstrap';

    /**
     * @param ApplicationInterface $application
     *
     * @throws Exception
     */
    public function __invoke(ApplicationInterface $application)
    {
        $application->getStep($this->plugInStep)->plug([$this, 'buildPhinx']);

        /** @var CliRouter $router */
        $router = $application->getServicesFactory()->get($this->cliRouterService);

        if($router) {
            $router->registerCommand(new Phinx());
        } else {
            throw new Exception('Cannot find ' . CliRouter::class . ' in ServicesFactory as "' . $this->cliRouterService . '"');
        }

    }

    /**
     * @param ApplicationInterface $app
     */
    public function buildPhinx(ApplicationInterface $app)
    {

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

    /**
     * Set PlugInStep
     *
     * @param string $plugInStep
     *
     * @return $this
     */
    public function setPlugInStep(string $plugInStep)
    {
        $this->plugInStep = $plugInStep;

        return $this;
    }
}
