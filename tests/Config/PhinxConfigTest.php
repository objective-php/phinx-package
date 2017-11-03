<?php
namespace Tests\ObjectivePHP\Package\Phinx\Config;

use ObjectivePHP\Package\Phinx\Config\PhinxConfig;
use PHPUnit\Framework\TestCase;

/**
 * Class PhinxConfigTest
 *
 * @package Tests\ObjectivePHP\Package\Phinx
 */
class PhinxConfigTest extends TestCase
{
    /**
     * @test
     */
    public function filePathAccessor()
    {
        $config = new PhinxConfig();
        $config->setFilePath('fake-path');

        $this->assertEquals('fake-path', $config->getFilePath());
        $this->assertAttributeEquals($config->getFilePath(), 'filePath', $config);
    }
}
