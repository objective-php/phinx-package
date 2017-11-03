# Objective PHP / Phinx Package

## Project introduction

This package allow to easily make use of the Phinx migration tool with Objective PHP

## Installation

### Manual

You can clone our Github repository by running:

```
git clone http://github.com/objective-php/phinx-package
```

If you're to proceed this way, you probably don't need more explanation about how to use the library :)

### Composer

The easiest way to install the library and get ready to play with it is by using Composer. Run the following command in an empty folder you just created:

```
composer require objective-php/phinx-package 
```

## How to test the work in progress?

### Run unit tests

First of all, please always run the unit tests suite. Our tests are written using PHPUnit, and can be run as follow:

```
vendor/bin/phpunit -c tests/phpunit.xml tests
```

### Configure the package

This package provide a configuration class that allows you to define the file where the package can find the Phinx configuration.

You can use it as follow:

```php
<?php

use ObjectivePHP\Package\Phinx\Config\PhinxConfig;

return [
    (new PhinxConfig())
        ->setFilePath('phinx.php')
];
```

After that you just need to plug the `PhinxPackage` class into any Objective PHP application:

```php
<?php
use ObjectivePHP\Application\AbstractApplication
use ObjectivePHP\Package\Phinx\PhinxPackage;

class Application extends AbstractApplication
{
    public function init()
    {
        // define your application workflow

        $this->getStep('bootstrap')
        	->plug(PhinxPackage::class);
		}
}
```