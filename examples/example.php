<?php
// Reuse the package autoloader.
$autoloader = require dirname(__DIR__) . '/vendor/autoload.php';

// Register test classes in the example folder.
$autoloader->addPsr4('Kambo\\Examples\\Deinj\\', 'src');

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
