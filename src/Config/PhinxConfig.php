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
    /** @var  string */
    protected $filePath;

    /**
     * PhinxConfig constructor.
     *
     * @param string|null $configFile
     */
    public function __construct(string $configFile = null)
    {
        parent::__construct($configFile);
    }

    /**
     * Get Path
     *
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * Set Path
     *
     * @param string $filePath
     *
     * @return PhinxConfig
     */
    public function setFilePath(string $filePath): PhinxConfig
    {
        $this->filePath = $filePath;

        $this->value = $filePath;

        return $this;
    }
}
