<?php
namespace ObjectivePHP\Package\Phinx\Command;

use ObjectivePHP\Application\ApplicationInterface;
use ObjectivePHP\Cli\Action\AbstractCliAction;
use ObjectivePHP\Package\Phinx\Config\PhinxConfig;
use Phinx\Config\Config;
use Phinx\Console\Command\AbstractCommand;
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * Class Phinx
 *
 * @package ObjectivePHP\Package\Phinx\Command
 */
class Phinx extends AbstractCliAction
{
    public function __construct()
    {
        $this->setCommand('phinx');
        $this->setDescription('Phinx console tool wrapper');
        $this->allowUnexpectedParameters();
    }

    /**
     * @param ApplicationInterface $application
     * @return mixed|void
     */
    public function run(ApplicationInterface $application)
    {
        $phinxConfig = $application->getConfig()->get(PhinxConfig::class);
        $config = new Config($phinxConfig);

        $phinxApplication = new PhinxApplication();

        $argv = $GLOBALS['argv'];
        array_shift($argv);

        $commandInput = new ArgvInput($argv);

        $reflexion = new \ReflectionClass(Application::class);
        $command = $reflexion->getProperty('commands');
        $command->setAccessible(true);

        $commands = $command->getValue($phinxApplication) ?? [];

        /** @var AbstractCommand $command */
        foreach ($commands as $command) {
            if (method_exists($command, 'setConfig')) {
                $command->setConfig($config);
                $command->bootstrap($commandInput, new NullOutput());

                foreach ($command->getManager()->getMigrations() as $migration) {
                    $application->getServicesFactory()->injectDependencies($migration);
                }
            }
        }

        $phinxApplication->run($commandInput);
    }
}
