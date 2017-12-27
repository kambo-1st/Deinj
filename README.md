# Deinj - simple dependency injection container
[![Build Status](https://travis-ci.org/kambo-1st/Deinj.svg?branch=master)](https://travis-ci.org/kambo-1st/KamboRouter)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kambo-1st/Deinj/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kambo-1st/KamboRouter/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/kambo-1st/Deinj.svg?style=flat-square)](https://scrutinizer-ci.com/g/kambo-1st/KamboRouter/)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Just another simple dependency injection container with following highlights:

* Support of PSR-11 - Container interface

## Install

Prefered way to install library is with composer:
```sh
composer require kambo/deinj
```

## Usage

```php
use Kambo\Deinj\Container;

use Kambo\Examples\Deinj\Transport;
use Kambo\Examples\Deinj\Mailer;
use Kambo\Examples\Deinj\UserManager;

// Create instance of the container.
$container = new Container;

// Set object factory method for identifier 'transport'.
$container->set(
    'transport',
    // Factory method is plain callback.
    function () {
        return new Transport();
    }
);

// Set object factory method for identifier 'mailer'.
$container->set(
    'mailer',
    // Factory method is plain callback. An instance of the container must be passed inside
    // the closure for allowing of the 'transport' injection.
    function ($container) {
        return new Mailer($container->get('transport'));
    }
);

// Set object factory method for identifier 'userManager'.
$container->set(
    'userManager',
    // Factory method is plain callback. An instance of the container must be passed inside
    // the closure for allowing of the 'mailer' injection.
    function ($container) {
        return new UserManager($container->get('mailer'));
    }
);

// Get instance of the UserManager service.
$userManager = $container->get('userManager');

// Call register method in the UserManager service.
$userManager->register('username', 'password');
```

## License
The MIT License (MIT), https://opensource.org/licenses/MIT
