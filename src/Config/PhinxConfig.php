<?php
namespace ObjectivePHP\Package\Phinx\Config;

use ObjectivePHP\Config\SingleValueDirective;

/**
 * Class PhinxConfig
 *
 * @package ObjectivePHP\Package\Phinx\Config
 */
class PhinxConfig extends SingleValueDirective
{
    /** @var  string[] */
    protected $paths;

    /** @var array */
    protected $environments;

    /**
     * PhinxConfig constructor.
     *
     * @param array $params params used by the config of Phinx
     */
    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    /**
     * Add a migration path
     *
     * @param string $name
     * @param string $path
     *
     * @return $this
     */
    public function addPath(string $name, string $path)
    {
        $this->paths[$name] = $path;

        $this->value['paths'] = $this->paths;

        return $this;
    }

    /**
     * Get Paths
     *
     * @return \string[]
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * Set Paths
     *
     * @param \string[] $paths
     *
     * @return $this
     */
    public function setPaths(array $paths)
    {
        $this->paths = $paths;
        return $this;
    }

    /**
     * Get Environments
     *
     * @return array
     */
    public function getEnvironments(): array
    {
        return $this->environments;
    }

    /**
     * Set Environments
     *
     * @param array $environments
     *
     * @return $this
     */
    public function setEnvironments(array $environments)
    {
        $this->environments = $environments;

        $this->value['environments'] = $this->environments;

        return $this;
    }
}
